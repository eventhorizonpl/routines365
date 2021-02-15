#!/bin/sh

bin/console app:create-missing-user-account-relation
bin/console doctrine:fixtures:load --append --group=v6deployment -n
