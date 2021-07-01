#!/bin/sh

if [ ! -e twigcs.phar ]
then
    wget https://github.com/friendsoftwig/twigcs/releases/download/v5.0.0/twigcs.phar
fi

php twigcs.phar templates
