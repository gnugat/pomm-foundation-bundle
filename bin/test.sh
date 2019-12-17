#!/usr/bin/env bash

PROJECT_ROOT="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"

echo ''
echo '// Building test environment'

if [ ! -f $PROJECT_ROOT/tests/App/config/parameters.yaml ]; then
    unset PROJECT_ROOT

    echo ''
    echo ' [FAIL] You must configure database in tests/App/config/parameters.yaml with be able to run the tests'
    echo ''

    exit 1
fi
unset PROJECT_ROOT

rm -rf tests/App/var/cache/* tests/App/var/log/*
composer --quiet --no-interaction update --optimize-autoloader > /dev/null

echo ''
echo ' [OK] Test environment built'
echo ''

vendor/bin/phpunit
