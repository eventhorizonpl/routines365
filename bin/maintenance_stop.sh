#!/bin/sh

bin/console lexik:maintenance:unlock -n
crond -b -l 8
