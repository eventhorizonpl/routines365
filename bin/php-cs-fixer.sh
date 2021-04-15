#!/bin/sh

if [ ! -e php-cs-fixer.phar ]
then
    wget https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v2.18.6/php-cs-fixer.phar
fi

php php-cs-fixer.phar fix --allow-risky=yes
