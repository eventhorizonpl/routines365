#!/bin/sh

bin/console doctrine:fixtures:load --append --group=v2deployment -n
