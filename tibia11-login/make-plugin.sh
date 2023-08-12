#!/usr/bin/env bash
VERSION=`cat plugins/tibia11-login.json | jq -r '.version'`
NAME=myaac-tibia11-login-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ login.php -x */\.*
