#!/bin/sh

bin/console doctrine:fixtures:load --append --group=v4deployment -n
bin/console app:create-missing-user-kyt
