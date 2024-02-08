#!/bin/bash
set -e

cd ~/public_html/_inc
echo "begin; select count(*) from translations; delete from translations where t_atime < strftime('%s', 'now') - 86400 and t_id not in (select distinct t_id from shares union select distinct t_id from feedback); commit; select count(*) from translations;" | sqlite3 -echo nutserut.sqlite > ~/cron-daily.log
