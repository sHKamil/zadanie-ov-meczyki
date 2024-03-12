#!/bin/bash
whoami
composer install
exec docker-php-entrypoint "$@"
