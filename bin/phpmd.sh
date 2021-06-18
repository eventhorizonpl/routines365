#!/bin/sh

if [ ! -e phpmd.phar ]
then
    wget https://github.com/phpmd/phpmd/releases/download/2.10.1/phpmd.phar
fi

if [ ! -d var/phpmd_report ]
then
    mkdir var/phpmd_report
fi

php phpmd.phar src/ html cleancode, codesize, controversial, design, naming, unusedcode > var/phpmd_report/report.html
