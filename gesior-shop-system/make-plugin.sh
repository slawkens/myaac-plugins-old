#!/usr/bin/env bash
rm -f myaac-gesior-shop-system.zip
zip -r myaac-gesior-shop-system.zip gesior-shop-system.lua images/ system/ payments/ plugins/ tools/ -x */\.*
