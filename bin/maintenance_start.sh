#!/bin/sh

killall crond
bin/console lexik:maintenance:lock 3600 -n
