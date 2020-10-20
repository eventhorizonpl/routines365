#!/bin/sh

bin/console lexik:maintenance:lock 3600 -n
bin/console cron:stop
