#!/bin/sh

exit 1

bin/console doctrine:fixtures:load --append --group=v4deployment -n
