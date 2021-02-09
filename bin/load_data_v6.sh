#!/bin/sh

bin/console doctrine:fixtures:load --append --group=v6deployment -n
