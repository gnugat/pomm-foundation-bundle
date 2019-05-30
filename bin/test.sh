#!/usr/bin/env bash

echo ''
echo '// Building test environment'

rm -rf tests/App/var/cache/* tests/App/var/log/*
composer --quiet --no-interaction update --optimize-autoloader > /dev/null

echo ''
echo ' [OK] Test environment built'
echo ''

vendor/bin/phpunit
