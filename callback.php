<?php

require_once __DIR__.'/vendor/autoload.php';

function normalize_text($txt) {
	$txt = preg_replace('~</?s[^>]*>~s', '', $txt);
	$txt = preg_replace('~\n[ \t]+~s', "\n", $txt);
	$txt = preg_replace('~[ \t]+\n~s', "\n", $txt);
	$txt = preg_replace('~[ \t][ \t]+~s', ' ', $txt);
	$txt = preg_replace('~\n\n\n+~s', "\n\n", $txt);
	$txt = trim($txt);
	if (empty($txt)) {
		return '';
	}

	if (mb_strlen($txt) > 500) {
		$txt = mb_substr($txt, 0, 500);
		$txt = preg_replace('~\S+\s*$~us', '', $txt);
		$txt .= ' …';
	}

	return $txt;
}

function handle_via_port($input, $port) {
	global $rv;

	$nonce = mt_rand();
	$nonced = "<s-$nonce>\n".$input."\n</s-$nonce>";

	$s = fsockopen('localhost', $port, $errno, $errstr, 1);
	if ($s === false) {
		header('X-Nutserut-Error: fsockopen '.$errno, false);
		$rv['errors'][] = 'fsockopen';
		return '';
	}
	if (fwrite($s, $nonced."\n<END-OF-INPUT>\n") === false) {
		header('X-Nutserut-Error: fwrite', false);
		$rv['errors'][] = 'fwrite';
		return '';
	}
	$output = stream_get_contents($s);
	if (!preg_match('~<s-'.$nonce.'>\n~', $output)) {
		header('X-Nutserut-Error: nonce', false);
		$rv['errors'][] = 'nonce';
		$output = '';
	}

	$output = preg_replace('~</?s[^>]*>~s', '', $output);
	$output = trim($output);
	return $output;
}

function b64_slug($rv) {
	$rv = base64_encode($rv);
	$rv = trim($rv, '=');
	$rv = str_replace('+', 'z', $rv);
	$rv = str_replace('/', 'Z', $rv);
	$rv = preg_replace('~^\d~', 'n', $rv);
	return $rv;
}

function json_encode_vb($v, $o=0) {
	return json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | $o);
}

header('Content-Type: application/json; charset=UTF-8');

$origin = '*';
if (!empty($_SERVER['HTTP_ORIGIN'])) {
	$origin = trim($_SERVER['HTTP_ORIGIN']);
}
header('Access-Control-Allow-Origin: '.$origin);
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header('HTTP/1.1 200 Options');
	header('Access-Control-Allow-Headers: HMAC, *');
	die();
}

$txt = normalize_text(strval($_POST['t'] ?? $_GET['t'] ?? ''));
$action = trim(strval($_POST['a'] ?? $_GET['a'] ?? ''));

$rv = [
	'input' => $txt,
	'action' => $action,
	'hash' => strtolower(substr(b64_slug(hash('sha256', "{$action}:{$txt}", true)), 0, 40)),
	'errors' => [],
	'garbage' => [],
	'gloss' => '',
	'moved' => '',
	'output' => '',
	];

if (!preg_match('~^dan2kal|kal2dan|kal2qda|kal2qdx$~', $action)) {
	$rv['errors'][] = 'Invalid action: '.$action;
}

while ($action === 'dan2kal') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$rv['output'] = handle_via_port($txt, 10300);
	break;
}

while ($action === 'kal2dan') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$rv['output'] = handle_via_port($txt, 10200);
	break;
}

while ($action === 'kal2qda') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$rv['output'] = handle_via_port($txt, 10250);
	break;
}

while ($action === 'kal2qdx') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$data = handle_via_port($txt, 10201);
	$c = '';
	$cs = explode("\n", $data);
	foreach ($cs as $l) {
		if (empty(trim($l))) {
			continue;
		}
		$l .= "\n";
		if ($c && $l[0] === '"' && $l[1] === '<') {
			preg_match('~^"<(.+?)>"~', $c, $w);
			if (preg_match('~ <Spell:(.+?)> ~', $c, $m)) {
				$rv['garbage'][] = ['spell', $w[1], $m[1]];
			}
			if (strpos($c, ' <heur>') !== false && preg_match('~\n\t(".+?"[^<]+)~', $c, $m)) {
				$rv['garbage'][] = ['heur', $w[1], $m[1]];
			}
			if (strpos($c, ' <xxx') !== false && preg_match('~\n\t(".+?"[^<]+)~', $c, $m)) {
				$rv['garbage'][] = ['heur', $w[1], $m[1]];
			}
			if (strpos($c, "\n\t\"") === false) {
				$rv['garbage'][] = ['null', $w[1]];
			}
			$c = '';
		}
		$c .= $l;
	}

	$rv['moved'] = handle_via_port($data, 10202);
	$rv['gloss'] = handle_via_port($txt, 10250);
	break;
}

foreach ($rv as $k => $v) {
	if (empty($v)) {
		unset($rv[$k]);
	}
}

if (!empty($rv['errors'])) {
	header('HTTP/1.1 400 Bad Request');
}
echo json_encode_vb($rv);
