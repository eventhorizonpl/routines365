#!/bin/sh

if [ ! -e phpmetrics.phar ]
then
    wget https://github.com/phpmetrics/PhpMetrics/releases/download/v2.7.3/phpmetrics.phar
fi

if [ ! -d var/phpmetrics_report ]
then
    mkdir var/phpmetrics_report
fi

php phpmetrics.phar --report-html=var/phpmetrics_report src/
