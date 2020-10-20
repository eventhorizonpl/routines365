#!/bin/sh

bin/console lexik:maintenance:unlock -n
bin/console cron:start
