<?php
declare(strict_types=1);
require_once __DIR__.'/_inc/lib.php';

if (PHP_SAPI === 'cli') {
	$db = db();
	$rv = $db->prepexec("SELECT t_pair, t_result FROM translations WHERE t_hash = ?", [$argv[1]])->fetchAll();
	if (!empty($rv)) {
		$action = $rv[0]['t_pair'];
		$txt = json_decode($rv[0]['t_result'], true)['i'];
	}
	else {
		echo "NOT FOUND: {$argv[1]}\n";
		exit(-1);
	}
}
else {
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
}

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
if (PHP_SAPI === 'cli' && $rv['hash'] !== $argv[1]) {
	echo "{$rv['hash']} !== {$argv[1]}\n";
	exit(-1);
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
		$rv['garbage'] = $result['e'] ?? [];
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

if (PHP_SAPI === 'cli') {
	exit(0);
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
