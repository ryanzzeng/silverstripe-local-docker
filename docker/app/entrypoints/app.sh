#!/usr/bin/env sh

echo "this is app.sh"

set -xe

/usr/bin/composer install --prefer-dist --optimize-autoloader --no-scripts --no-progress --no-suggest;

# update database
until /app/vendor/bin/sake dev/build >/dev/null 2>&1; do
	(>&2 echo "Waiting for MySQL to be ready...")
	sleep 1
done


# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
