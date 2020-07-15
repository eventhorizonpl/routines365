#!/bin/sh

if [ ! -e php-cs-fixer.phar ]
then
    sh bin/get_php_cs_fixer.sh
fi

php php-cs-fixer.phar fix src/ --rules=@Symfony
