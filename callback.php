<?php
declare(strict_types=1);
require_once __DIR__.'/vendor/autoload.php';

$GLOBALS['-db'] = null;

function db(): object {
	if ($GLOBALS['-db']) {
		return $GLOBALS['-db'];
	}

	$db_file = __DIR__.'/nutserut.sqlite';
	$existed = file_exists($db_file) && (filesize($db_file) > 4096);

	$db = new \TDC\PDO\SQLite($db_file);

	$db->exec("PRAGMA auto_vacuum = INCREMENTAL");
	$db->exec("PRAGMA case_sensitive_like = ON");
	$db->exec("PRAGMA foreign_keys = ON");
	$db->exec("PRAGMA journal_mode = WAL");
	$db->exec("PRAGMA locking_mode = EXCLUSIVE");
	$db->exec("PRAGMA synchronous = NORMAL");
	$db->exec("PRAGMA threads = 4");
	$db->exec("PRAGMA trusted_schema = OFF");

	if (!$existed) {
		$db->exec(file_get_contents(__DIR__.'/schema.sql'));
	}

	$GLOBALS['-db'] = $db;
	return $db;
}

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

function save_translation($hash, $pair, $result) {
	$db = db();
	$db->beginTransaction();
	$upd = $db->prepare("UPDATE translations SET t_atime = strftime('%s', 'now'), t_hits = t_hits + 1 WHERE t_hash = ?");
	$upd->execute([$hash]);
	if ($upd->rowCount() == 0) {
		$db->prepexec("INSERT INTO translations (t_hash, t_pair, t_result) VALUES (?, ?, ?)", [$hash, $pair, json_encode_vb($result)]);
	}
	$db->commit();
}

function load_translation($hash) {
	$db = db();
	$rv = $db->prepexec("SELECT t_result FROM translations WHERE t_hash = ?", [$hash])->fetchAll();
	if (!empty($rv)) {
		return json_decode($rv[0]['t_result'], true);
	}
	return false;
}

function hashify(&$rv) {
	$rv['hash'] = strtolower(substr(b64_slug(hash('sha256', "{$rv['action']}:{$rv['input']}", true)), 0, 40));
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
	die();
}

$txt = normalize_text(strval($_POST['t'] ?? $_GET['t'] ?? ''));
$action = trim(strval($_POST['a'] ?? $_GET['a'] ?? ''));

$rv = [
	'input' => $txt,
	'action' => $action,
	'errors' => [],
	'garbage' => [],
	'gloss' => '',
	'moved' => '',
	'output' => '',
	];

if (!preg_match('~^share|load|feedback|dan2kal|kal2dan|kal2qda|kal2qdx$~', $action)) {
	$rv['errors'][] = 'Invalid action: '.$action;
}
if (preg_match('~^dan2kal|kal2dan|kal2qda|kal2qdx$~', $action)) {
	hashify($rv);
}

while ($action === 'share') {
	$hash = trim(strval($_POST['hash'] ?? ''));

	$db = db();
	$db->beginTransaction();
	$res = $db->prepexec("SELECT t_id FROM translations WHERE t_hash = ?", [$hash])->fetchAll();
	if (empty($res)) {
		$rv['errors'][] = 'No such translation: '.$hash;
		$db->rollback();
		break;
	}
	$id = intval($res[0]['t_id']);
	$res = $db->prepexec("SELECT s_slug FROM shares WHERE t_id = ?", [$id])->fetchAll();
	if (!empty($res)) {
		$rv['slug'] = $res[0]['s_slug'];
	}
	else {
		$sel = $db->prepare("SELECT t_id FROM shares WHERE s_slug = ?");
		$ins = $db->prepare("INSERT INTO shares (t_id, s_slug, s_ip) VALUES (?, ?, ?)");
		for ($i=3 ; $i<strlen($hash) ; ++$i) {
			$slug = substr($hash, 0, $i);
			$sel->execute([$slug]);
			$res = $sel->fetchAll();
			if (empty($res)) {
				$ins->execute([$id, $slug, $_SERVER['REMOTE_ADDR']]);
				$rv['slug'] = $slug;
				break;
			}
		}
	}
	$db->commit();

	break;
}

while ($action === 'load') {
	$slug = trim(strval($_POST['slug'] ?? ''));

	$db = db();
	$res = $db->prepexec("SELECT t_id FROM shares WHERE s_slug = ?", [$slug])->fetchAll();
	if (empty($res)) {
		$rv['errors'][] = 'No such shared translation: '.$slug;
		break;
	}
	$db->prepexec("UPDATE translations SET t_atime = strftime('%s', 'now'), t_hits = t_hits + 1 WHERE t_id = ?", [$res[0]['t_id']]);
	$res = $db->prepexec("SELECT t_hash, t_pair, t_result FROM translations WHERE t_id = ?", [$res[0]['t_id']])->fetchAll();
	$res = $res[0];

	$rv['action'] = $res['t_pair'];
	$rv['hash'] = $res['t_hash'];
	$res = json_decode($res['t_result'], true);
	$rv['input'] = $res['i'];
	$rv['output'] = $res['o'] ?? '';
	$rv['moved'] = $res['m'] ?? '';
	$rv['gloss'] = $res['g'] ?? '';
	$rv['garbage'] = $res['e'] ?? [];
	break;
}

while ($action === 'feedback') {
	$hash = trim(strval($_POST['hash'] ?? ''));
	$which = intval($_POST['which'] ?? 0);
	$comment = normalize_text(strval($_POST['comment'] ?? ''));
	if (empty($comment) || !preg_match('~\pL~', $comment)) {
		$rv['errors'][] = 'Invalid comment - either empty or no letters';
		break;
	}
	$email = trim(strval($_POST['email'] ?? ''));
	if (!empty($email) && !preg_match('~^\S+?@\S+?\.\S+$~u', $email)) {
		$rv['errors'][] = 'Invalid email: '.$email;
		break;
	}

	$db = db();
	$res = $db->prepexec("SELECT t_id FROM translations WHERE t_hash = ?", [$hash])->fetchAll();
	if (empty($res)) {
		$rv['errors'][] = 'No such translation: '.$hash;
		$db->rollback();
		break;
	}
	$id = intval($res[0]['t_id']);
	$db->prepexec("INSERT INTO feedback (t_id, f_which, f_comment, f_email, f_ip) VALUES (?, ?, ?, ?, ?)", [$id, $which, $comment, $email, $_SERVER['REMOTE_ADDR']]);
	break;
}

while ($action === 'dan2kal') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$result = load_translation($rv['hash']);
	if (!empty($result)) {
		$rv['output'] = $result['o'];
	}
	else {
		$rv['output'] = handle_via_port($txt, 10300);
	}
	save_translation($rv['hash'], $rv['action'], ['i' => $rv['input'], 'o' => $rv['output']]);
	break;
}

while ($action === 'kal2dan') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$result = load_translation($rv['hash']);
	if (!empty($result)) {
		$rv['output'] = $result['o'];
	}
	else {
		$rv['output'] = handle_via_port($txt, 10200);
	}
	save_translation($rv['hash'], $rv['action'], ['i' => $rv['input'], 'o' => $rv['output']]);
	break;
}

while ($action === 'kal2qda') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$result = load_translation($rv['hash']);
	if (!empty($result)) {
		$rv['output'] = $result['o'];
	}
	else {
		$rv['output'] = handle_via_port($txt, 10250);
	}
	save_translation($rv['hash'], $rv['action'], ['i' => $rv['input'], 'o' => $rv['output']]);
	break;
}

while ($action === 'kal2qdx') {
	if (empty($txt) || !preg_match('~\pL~iu', $txt)) {
		$rv['errors'][] = 'No letters in input: '.$txt;
		break;
	}

	$result = load_translation($rv['hash']);
	if (!empty($result)) {
		$rv['input'] = $result['i'];
		$rv['moved'] = $result['m'];
		$rv['gloss'] = $result['g'];
		$rv['garbage'] = $result['e'];
	}
	else {
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
		$result = ['i' => $rv['input'], 'm' => $rv['moved'], 'g' => $rv['gloss']];
		if (!empty($rv['garbage'])) {
			$result['e'] = $rv['garbage'];
		}
	}
	save_translation($rv['hash'], $rv['action'], $result);
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
