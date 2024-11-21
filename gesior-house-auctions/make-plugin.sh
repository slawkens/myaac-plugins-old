#!/usr/bin/env bash
VERSION=`cat plugins/gesior-house-auctions.json | jq -r '.version'`
NAME=myaac-gesior-house-auctions-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ images/ -x */\.*
