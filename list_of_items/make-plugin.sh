#!/usr/bin/env bash
rm -f myaac-list-of-items.zip
zip -r myaac-list-of-items.zip system/ plugins/ -x */\.*
