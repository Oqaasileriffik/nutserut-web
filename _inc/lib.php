<?php
declare(strict_types=1);
putenv('LC_ALL=C.UTF-8');
putenv('PERL_UNICODE=SDA');
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

function handle_via_nmt($hash, $pair, $input) {
	$ps = explode('-', $pair);
	if ($ps[0] === 'h') {
		$input = "<s1>\n{$input}\n</s1>";
	}
	file_put_contents("/tmp/{$pair}-{$hash}.in.txt", $input);

	shell_exec("cat '/tmp/{$pair}-{$hash}.in.txt' | /opt/nutserut/models/{$ps[0]}/tok-{$ps[1]}.sh > '/tmp/{$pair}-{$hash}.in.bpe'");
	shell_exec("/opt/nutserut/models/{$ps[0]}/trx.sh '{$ps[1]}' '/tmp/{$pair}-{$hash}.in.bpe' '/tmp/{$pair}-{$hash}.out.bpe' >'/tmp/{$pair}-{$hash}.log' 2>&1");

	$output = file_get_contents("/tmp/{$pair}-{$hash}.out.bpe");
	$output = preg_replace('~@@( |$)~', '', $output);
	$output = trim($output);

	/*
	$output = explode("\n", $output);
	for ($i=0,$e=count($output) ; $i<$e ; ++$i) {
		$output[$i] = (($i%5)+1).': '.$output[$i];
	}
	$output = implode("\n\n", $output);
	//*/

	return $output;
}

function handle_via_gloss($hash, $pair, $input) {
	$ps = explode('-', $pair);
	file_put_contents("/tmp/{$pair}-{$hash}.in.txt", $input);

	shell_exec("cat '/tmp/{$pair}-{$hash}.in.txt' | /opt/nutserut/gloss/{$ps[1]}/public.pl | grep -v '¶' >'/tmp/{$pair}-{$hash}.out' 2>'/tmp/{$pair}-{$hash}.log'");

	$output = file_get_contents("/tmp/{$pair}-{$hash}.out");
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

function page_header($title='SITE_TITLE') {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-l10n="<?=$title;?>">Nutserut - Greenlandic-Danish Machine Translation</title>

	<link rel="shortcut icon" href="https://oqaasileriffik.gl/favicon.ico">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gudea%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=5.5.3" type="text/css" media="all" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="_static/nutserut.css?<?=filemtime(__DIR__.'/../_static/nutserut.css');?>">
	<link rel="alternate" hreflang="da" href="https://nutserut.gl/da">
	<link rel="alternate" hreflang="kl" href="https://nutserut.gl/kl">
	<link rel="alternate" hreflang="en" href="https://nutserut.gl/en">
	<link rel="alternate" hreflang="x-default" href="https://nutserut.gl/">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="_static/l10n.js?<?=filemtime(__DIR__.'/../_static/l10n.js');?>"></script>
	<script src="_static/nutserut.js?<?=filemtime(__DIR__.'/../_static/nutserut.js');?>"></script>
</head>
<body class="d-flex flex-column">

<header>
	<div class="container">
	<div class="logo">
		<a href="https://oqaasileriffik.gl/" class="text-decoration-none">
		<h1 data-l10n="HDR_TITLE">Oqaasileriffik</h1>
		<h3 data-l10n="HDR_SUBTITLE">The Language Secretariat of Greenland</h3>
		</a>
	</div>
	</div>

	<div class="menu">
	<div class="container">
		<div class="lang-select">
			<a class="dropdown text-decoration-none fs-5" id="dropLanguages" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"><i class="bi bi-globe2"></i></a>
			<ul class="dropdown-menu" aria-labelledby="dropLanguages">
				<li><a href="./kl" class="item l10n" data-which="kl" title="Kalaallisut"><tt>KAL</tt> <span>Kalaallisut</span></a></li>
				<li><a href="./da" class="item l10n" data-which="da" title="Dansk"><tt>DAN</tt> <span>Dansk</span></a></li>
				<li><a href="./en" class="item l10n" data-which="en" title="English"><tt>ENG</tt> <span>English</span></a></li>
			</ul>
		</div>
	</div>
	</div>
</header>

<div class="container flex-grow-1">

<?php
}
