#!/usr/bin/env bash
VERSION=`cat plugins/list_of_items.json | jq -r '.version'`
NAME=myaac-list-of-items-v$VERSION.zip
rm -f $NAME
zip -r $NAME system/ plugins/ -x */\.*
