#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__.'/lib.php';

if (!empty($_SERVER['REMOTE_ADDR'])) {
	die("No remote use!");
}

$db = db();

$since = strtotime($argv[1] ?? '1970-01-01 00:00:00');
$until = strtotime($argv[2] ?? '2100-01-01 00:00:00');
echo "Since: $since; Until: $until\n";

$trs = [];
$pairs = [];
$stm = $db->prepexec("SELECT * FROM translations WHERE t_ctime >= ? AND t_ctime < ? ORDER BY t_id ASC", [$since, $until]);
while ($row = $stm->fetch()) {
	$row['t_result'] = json_decode($row['t_result'], true);
	$trs[$row['t_id']] = $row;
	$pairs[$row['t_pair']][$row['t_id']] = $row;
}

$first = date('Ymd', intval(current($trs)['t_ctime']));

foreach ($pairs as $p => $ts) {
	$fh = fopen("trx-$p-$first.csv", 'wb');
	$fields = "ID,Date,Input";
	if (array_key_exists('o', current($ts)['t_result'])) {
		$fields .= ",Output";
	}
	if (array_key_exists('g', current($ts)['t_result'])) {
		$fields .= ",Glossed";
	}
	if (array_key_exists('m', current($ts)['t_result'])) {
		$fields .= ",Moved";
	}
	$fields .= "\n";
	fwrite($fh, $fields);
	foreach ($ts as $t) {
		$t['t_ctime'] = date('Y-m-d H:i:s', intval($t['t_ctime']));
		$fields = [$t['t_id'], $t['t_ctime'], normalize_text($t['t_result']['i'])];
		if (array_key_exists('o', $t['t_result'])) {
			$fields[] = normalize_text($t['t_result']['o']);
		}
		if (array_key_exists('g', $t['t_result'])) {
			$fields[] = normalize_text($t['t_result']['g']);
		}
		if (array_key_exists('m', $t['t_result'])) {
			$fields[] = normalize_text($t['t_result']['m']);
		}
		fputcsv($fh, $fields);
	}
	fclose($fh);
}

$fh = fopen("feedback-$first.txt", 'wb');
$stm = $db->prepexec("SELECT * FROM feedback WHERE f_ctime >= ? AND f_ctime < ? ORDER BY f_id ASC", [$since, $until]);
while ($row = $stm->fetch()) {
	$out = "";
	$out .= "ID: {$row['f_id']}\n";
	$out .= "Translation ID: {$row['t_id']}\n";
	$out .= "Translation input: ".str_replace("\n", ' \n ', normalize_text($trs[$row['t_id']]['t_result']['i']))."\n";
	$out .= "Feedback for: ".implode(" ; ", $trs[$row['t_id']]['t_result']['e'][$row['f_which']])."\n";
	if (!empty($row['f_email'])) {
		$out .= "Feedback from: {$row['f_email']}\n";
	}
	$out .= "Feedback: {$row['f_comment']}\n";
	$out .= "\n================\n";
	fwrite($fh, $out);
}
fclose($fh);

if (filesize("feedback-$first.txt") === 0) {
	unlink("feedback-$first.txt");
}
