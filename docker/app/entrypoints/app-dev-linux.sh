#!/usr/bin/env sh

echo "this is app-dev-linux.sh"

# Create a user within the container with the required USER_UID
# Note: Not really required for PHP FPM but it makes the container look nicer when you exec into it.
adduser -u ${USER_UID} developer -D || true

# Set the UID and GID that PHP FPM's workers should use.
sed -i 's/^user = www-data/user = '"${USER_UID}"'/g' /usr/local/etc/php-fpm.d/www.conf
sed -i 's/^group = www-data/group = '"${USER_GID}"'/g' /usr/local/etc/php-fpm.d/www.conf

# Fix permissions of files created during build
chown -Rf "${USER_UID}:${USER_GID}" /app/ || true

# Proceed to launch PHP-FPM
exec "php-fpm"
