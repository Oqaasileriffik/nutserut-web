#!/usr/bin/env php
<?php

if (!empty($_SERVER['REMOTE_ADDR'])) {
	die('Not for remote use.');
}

$l10n = [];
$keys = [];

$gdocs = [
	'https://docs.google.com/spreadsheets/d/1UbTdfRDnKDEfL4WHY0NYuyuNFIYQR59rRmB2Kiyx8Zk/export?exportFormat=csv', // Shared
	'https://docs.google.com/spreadsheets/d/1vP57QButvuGnP-4TSf_-W9Fs-QNXrDLLIj-enpF7doI/export?exportFormat=csv',
	];
$csv = fopen('php://memory', 'w+b');
foreach ($gdocs as $gd) {
	fwrite($csv, file_get_contents($gd));
	fwrite($csv, "\n");
}
fseek($csv, 0);

$iso = fgetcsv($csv);
echo implode("\t", $iso)."\n";

$suf = '';
if (!empty($argv[1])) {
	$suf = '-'.$argv[1];
}

while ($l = fgetcsv($csv)) {
	if (!preg_match('~^[_A-Z0-9]+$~', $l[0])) {
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

//echo var_export($l10n, true), "\n";

$used = trim(shell_exec("pcregrep --buffer-size=1M -r '".implode('|', $keys)."' *"));
//echo "$used\n";

$php = [];
$js = [];
foreach ($keys as $k) {
	$hit = false;
	if (strpos($used, "{l10n:$k}") !== false) {
		$php[$k] = $k;
		$hit = true;
	}
	if (strpos($used, "l10n('$k'") !== false) {
		$php[$k] = $k;
		$hit = true;
	}
	if (strpos($used, "l10n.t('$k'") !== false || strpos($used, "l10n_translate('$k'") !== false) {
		$js[$k] = $k;
		$hit = true;
	}
	if (strpos($used, "data-l10n=\"$k\"") !== false || strpos($used, "data-l10n-alt=\"$k\"") !== false || strpos($used, "data-l10n-href=\"$k\"") !== false) {
		$js[$k] = $k;
		$hit = true;
	}
	if (!$hit && strpos($used, "'$k'") !== false) {
		$js[$k] = $k;
	}
}

echo 'PHP: '.implode(', ', $php)."\n";
echo 'JS: '.implode(', ', $js)."\n";

for ($i=1 ; $i<4 ; ++$i) {
	$file = "<?php\n";
	foreach ($php as $k) {
		$t = $l10n[$iso[$i]][$k];
		if (!empty($t)) {
			$out[$k] = $t;
			$file .= "\$GLOBALS['-l10n']['{$iso[$i]}']['{$k}'] = ".var_export($t, true).";\n";
		}
	}
	file_put_contents("l10n-{$iso[$i]}{$suf}.php", $file);
}

$out = <<<XOUT
/*!
 * Copyright 2021-2022 Oqaasileriffik <oqaasileriffik@oqaasileriffik.gl> at https://oqaasileriffik.gl/
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

let l10n = {
	lang: 'en',
	s: {},
	};

XOUT;
for ($i=1 ; $i<4 ; ++$i) {
	$out .= "\nl10n.s.{$iso[$i]} = {\n";
	foreach ($js as $k) {
		$t = $l10n[$iso[$i]][$k];
		if (!empty($t)) {
			$out .= "\t$k: ".json_encode($t, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).",\n";
		}
	}
	$out .= "};\n";
}

$out .= <<<XOUT

l10n.s.da = l10n.s.dan;
l10n.s.en = l10n.s.eng;
l10n.s.kl = l10n.s.kal;

XOUT;
file_put_contents("l10n.js", $out);
