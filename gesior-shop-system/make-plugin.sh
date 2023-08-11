#!/usr/bin/env bash
VERSION=`cat plugins/gesior-shop-system.json | jq -r '.version'`
rm -f myaac-gesior-shop-system-v$VERSION.zip
zip -r myaac-gesior-shop-system-v$VERSION.zip lua/ admin/ system/ payments/ plugins/ -x */\.*
