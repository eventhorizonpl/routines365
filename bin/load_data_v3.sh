#!/bin/sh

bin/console doctrine:fixtures:load --append --group=v3deployment -n
