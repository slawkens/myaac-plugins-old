#!/usr/bin/env bash
rm -f myaac-gesior-shop-system.zip
zip -r myaac-gesior-shop-system.zip lua/ admin/ system/ payments/ plugins/ -x */\.*
