#!/usr/bin/env php
<?php

if (!empty($_SERVER['REMOTE_ADDR'])) {
	die('Not for remote use.');
}

$l10n = [];
$keys = [];

$gdocs = [
	'https://docs.google.com/spreadsheets/d/1ISQ2KyXqSw-YlnNqSw7DrMM1oB7elI-izAV6Nuu1WWo/export?exportFormat=csv',
	];
$csv = fopen('php://memory', 'w+b');
foreach ($gdocs as $gd) {
	fwrite($csv, file_get_contents($gd));
	fwrite($csv, "\n");
}
fseek($csv, 0);

$iso = fgetcsv($csv);

$suf = '';
if (!empty($argv[1])) {
	$suf = '-'.$argv[1];
}

while ($l = fgetcsv($csv)) {
	if (preg_match('~[\s\pZ]~u', $l[0]) || empty($l[1])) {
		continue;
	}
	if (array_key_exists($l[0], $keys)) {
		fprintf(STDERR, "Duplicate key %s\n", $l[0]);
		//break;
	}
	$keys[$l[0]] = $l[0];

	for ($i=1 ; $i<4 ; ++$i) {
		$t = trim($l[$i] ?? '');
		$l10n[$iso[$i]][$l[0]] = $t;
	}
}

sort($keys);

$out = <<<XOUT
/*!
 * Copyright 2024 Oqaasileriffik <oqaasileriffik@oqaasileriffik.gl> at https://oqaasileriffik.gl/
 *
 * This project is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This project is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this project.  If not, see <http://www.gnu.org/licenses/>.
 */
'use strict';

XOUT;
for ($i=1 ; $i<4 ; ++$i) {
	$out .= "\nl10n.tags.{$iso[$i]} = {\n";
	foreach ($keys as $k) {
		$t = $l10n[$iso[$i]][$k];
		if (!empty($t)) {
			$out .= "\t".json_encode($k, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).": ".json_encode($t, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).",\n";
		}
	}
	$out .= "};\n";
}

$out .= <<<XOUT

l10n.tags.da = l10n.tags.dan;
l10n.tags.en = l10n.tags.eng;
l10n.tags.kl = l10n.tags.kal;

XOUT;
file_put_contents("l10n-tags.js", $out);
