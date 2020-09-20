FROM php:7.4-fpm-alpine AS php_build

RUN apk add --no-cache \
  libxslt \
  libzip \
  nginx \
  zlib
RUN apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS \
  libxslt-dev \
  libzip-dev \
  zlib-dev

RUN docker-php-ext-configure xsl \
  && docker-php-ext-install xsl \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip \
  && pecl install apcu \
  && pecl clear-cache \
  && docker-php-ext-enable apcu opcache

RUN rm -rf /tmp/pear/
RUN apk del .build-deps

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG APP_ENV=prod

COPY composer.json composer.lock package.json symfony.lock webpack.config.js yarn.lock ./

RUN composer install --prefer-dist --no-scripts --no-progress --no-suggest \
  && composer clear-cache

COPY .env ./
RUN composer dump-env prod \
  && rm .env

COPY bin bin/
COPY config config/
COPY migrations migrations/
COPY public public/
COPY src src/
COPY templates templates/
COPY translations translations/
RUN mkdir -p var/cache var/log
VOLUME /var/www/html/var

FROM php_build as php_build_assets

RUN apk add --no-cache \
  nodejs \
  npm \
  yarn

COPY assets assets/
RUN yarn install
RUN yarn encore production

FROM php_build as php_build_final
COPY --from=php_build_assets /var/www/html/public/build /var/www/html/public/build

COPY docker/php/conf.d/prod.ini $PHP_INI_DIR/conf.d/prod.ini
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

#RUN sh bin/deploy_install.sh
