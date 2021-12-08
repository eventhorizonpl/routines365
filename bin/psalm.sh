#!/bin/sh

if [ ! -e psalm.phar ]
then
    wget https://github.com/vimeo/psalm/releases/download/v4.15.0/psalm.phar
fi

if [ ! -d var/psalm_report ]
then
    mkdir var/psalm_report
fi

php psalm.phar --show-info=false > var/psalm_report/report.txt
