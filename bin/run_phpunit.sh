#!/bin/sh

if [ ! -d var/phpunit_report ]
then
    mkdir var/phpunit_report
fi

bin/console doctrine:database:drop --force --env=test
bin/console doctrine:database:create --env=test
bin/console doctrine:migrations:migrate --no-interaction --env=test -v

SYMFONY_PHPUNIT_VERSION=9.5 bin/phpunit --coverage-html var/phpunit_report --stop-on-error --stop-on-failure --verbose
