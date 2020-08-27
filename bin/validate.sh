#!/bin/sh

bin/console doctrine:schema:validate
bin/console lint:container
bin/console lint:twig templates/
bin/console lint:xliff translations/
bin/console lint:yaml config/
bin/console security:check
