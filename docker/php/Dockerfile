FROM php:8.1.2-fpm-alpine3.15 AS php_build

RUN apk add --no-cache \
  acl \
  icu \
  libxslt \
  libzip \
  zlib \
  && apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS \
  icu-dev \
  libxslt-dev \
  libzip-dev \
  zlib-dev

RUN docker-php-ext-install intl \
  mysqli \
  opcache \
  pdo \
  pdo_mysql \
  pcntl \
  xsl \
  zip \
  && pecl install apcu \
  && pecl clear-cache \
  && docker-php-ext-enable apcu \
  opcache \
  pdo_mysql

RUN rm -rf /tmp/pear/ \
  && apk del .build-deps

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/prod.ini $PHP_INI_DIR/conf.d/prod.ini

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG APP_ENV=prod

COPY composer.json composer.lock package.json symfony.lock webpack.config.js yarn.lock ./

RUN composer install --prefer-dist --no-interaction --no-scripts --no-progress --no-suggest --no-dev \
  && composer clear-cache

COPY .env .env.prod.local  ./
RUN composer dump-env prod \
  && rm .env .env.prod.local

COPY bin bin/
COPY config config/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY templates templates/
COPY translations translations/
RUN mkdir -p var/cache var/log
VOLUME /var/www/html/var

RUN echo "* * * * * /var/www/html/bin/console cron:run 1>> /dev/null 2>&1" >> /var/spool/cron/crontabs/root

STOPSIGNAL SIGQUIT
CMD ["crond", "-f"]
