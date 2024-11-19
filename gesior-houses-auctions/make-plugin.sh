#!/usr/bin/env bash
VERSION=`cat plugins/gesior-houses-auctions.json | jq -r '.version'`
NAME=myaac-gesior-houses-auctions-v$VERSION.zip
rm -f $NAME
zip -r $NAME plugins/ system/ images/ -x */\.*
