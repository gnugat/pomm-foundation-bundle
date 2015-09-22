#!/usr/bin/env bash

echo ''
echo '// Building test environment'

rm -rf Tests/app/cache/* Tests/app/logs/*
composer --quiet --no-interaction update --optimize-autoloader  > /dev/null

echo ''
echo ' [OK] Test environment built'
echo ''

vendor/bin/phpunit \
    vendor/bin/phpspec run --no-interaction -f dot
