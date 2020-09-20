#!/bin/sh

rm -rf var/cache/*

bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate --no-interaction

bin/console cache:warmup --env=prod --no-debug
