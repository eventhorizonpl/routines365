#!/bin/sh

if [ ! -e phpcpd.phar ]
then
    wget https://phar.phpunit.de/phpcpd.phar
fi

if [ ! -d var/phpcpd_report ]
then
    mkdir var/phpcpd_report
fi

php phpcpd.phar --fuzzy src/ > var/phpcpd_report/report.txt
