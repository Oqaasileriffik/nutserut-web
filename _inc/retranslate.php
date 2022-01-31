#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__.'/lib.php';

if (!empty($_SERVER['REMOTE_ADDR'])) {
	die("No remote use!");
}

$db = db();

$trs = [];
$stm = $db->prepexec("SELECT * FROM translations ORDER BY t_id ASC");
while ($row = $stm->fetch()) {
	$row['t_result'] = json_decode($row['t_result'], true);
	$trs[$row['t_id']] = $row;
}

foreach ($trs as $tr) {
	$cmd = 'php '.__DIR__.'/../callback.php '.escapeshellarg($tr['t_hash']).' '.escapeshellarg($tr['t_pair']).' '.escapeshellarg($tr['t_result']['i']);
	echo shell_exec($cmd);
}
