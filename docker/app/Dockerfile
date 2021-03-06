##########################################
# STAGE: base
##########################################
FROM php:7.4-fpm-alpine AS base

# Install PHP extensions and build dependencies
# set -xe: exit immediately if non-zero status and print commands and their arguments in a sequential way
# docker-php-ext-configure: that configures an extension before it gets installed
# docker-php-ext-install: that installs extension(s)
# docker-php-ext-enable: enable extension(s)
RUN set -xe \
    && apk add --no-cache --update \
        bash \
        freetype \
        icu \
        libjpeg \
        libpng \
        libxpm \
        libzip \
        tidyhtml \
    && apk add --no-cache --virtual .php-deps \
        make \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        freetype-dev \
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxpm-dev \
        libzip-dev \
        tidyhtml-dev \
        g++ \
    && docker-php-ext-configure gd --with-freetype --with-jpeg  \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-install -j$(nproc) \
 		intl \
 		gd \
 		mysqli \
 		pdo \
 		pdo_mysql \
 		tidy \
    && docker-php-ext-enable \
 		intl \
 		gd \
 		mysqli \
 		pdo \
 		pdo_mysql \
 		tidy \
    && apk del .build-deps \
    && rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/*

# php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/app/conf.d/custom.ini $PHP_INI_DIR/conf.d/custom.ini

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --no-progress --no-cache


# define workdir and copy application files
WORKDIR /app
ADD . /app

# Finish the composer install and generate an autoloader now that the full app is copied in
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader --no-cache


##########################################
# STAGE: app
##########################################
FROM base AS app

EXPOSE 9000


