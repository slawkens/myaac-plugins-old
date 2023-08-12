#!/usr/bin/env bash
VERSION=`cat plugins/pagseguro.json | jq -r '.version'`
NAME=myaac-pagseguro-v$VERSION.zip
rm -f $NAME
zip -r $NAME images/ system/ payments/ plugins/ -x */\.*
