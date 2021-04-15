#!/bin/sh

rm -rf var/cache/*

bin/console doctrine:migrations:migrate --no-interaction -v

sh bin/restore_acl.sh
bin/console cache:warmup --env=prod --no-debug
