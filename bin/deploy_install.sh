#!/bin/sh

exit 1

rm -rf var/cache/*

bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate -n -v
bin/console doctrine:fixtures:load --group=v1deployment -n

sh bin/restore_acl.sh
bin/console cache:warmup --env=prod --no-debug
