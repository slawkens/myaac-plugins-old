#!/usr/bin/env bash
VERSION=`cat plugins/rasta-template.json | jq -r '.version'`
rm -f myaac-rasta-template-$VERSION.zip
zip -r myaac-rasta-template-$VERSION.zip templates/ plugins/ -x */\.*
