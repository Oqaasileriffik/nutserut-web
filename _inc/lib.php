<?php
declare(strict_types=1);
putenv('LC_ALL=C.UTF-8');
setlocale(LC_ALL, 'C.UTF-8');
require_once __DIR__.'/../_vendor/autoload.php';

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
	$db->exec("PRAGMA locking_mode = NORMAL");
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
	$txt = str_replace("\r\n", "\n", $txt);
	$txt = str_replace("\r", '', $txt);
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
		$txt = trim($txt);
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

	$output = preg_replace('~(^|\n)</?s[^>]*>~s', '', $output);
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
	if (PHP_SAPI === 'cli') {
		$result = json_encode_vb($result);
		$rv = $db->prepexec("SELECT t_result FROM translations WHERE t_hash = ?", [$hash])->fetchAll();
		if ($rv[0]['t_result'] === $result) {
			echo "UNCHANGED: {$hash}\n";
			$db->rollback();
			return;
		}
		$upd = $db->prepexec("UPDATE translations SET t_result = ? WHERE t_hash = ?", [$result, $hash]);
		if ($upd->rowCount() != 0) {
			echo "UPDATED: {$hash}\n";
		}
	}
	else {
		$upd = $db->prepare("UPDATE translations SET t_atime = strftime('%s', 'now'), t_hits = t_hits + 1 WHERE t_hash = ?");
		$upd->execute([$hash]);
		if ($upd->rowCount() == 0) {
			$db->prepexec("INSERT INTO translations (t_hash, t_pair, t_result) VALUES (?, ?, ?)", [$hash, $pair, json_encode_vb($result)]);
		}
	}
	$db->commit();
}

function load_translation($hash) {
	if (PHP_SAPI === 'cli') {
		return false;
	}

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
