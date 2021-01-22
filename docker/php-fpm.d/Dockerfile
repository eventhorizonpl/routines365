FROM php:7.4.14-fpm-alpine3.13 AS php_build

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

RUN docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && docker-php-ext-install mysqli pdo pdo_mysql \
  && docker-php-ext-enable pdo_mysql \
  && docker-php-ext-configure pcntl \
  && docker-php-ext-install pcntl \
  && docker-php-ext-configure xsl \
  && docker-php-ext-install xsl \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip \
  && pecl install apcu \
  && pecl clear-cache \
  && docker-php-ext-enable apcu opcache

RUN rm -rf /tmp/pear/ \
  && apk del .build-deps

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

ARG APP_ENV=prod

COPY composer.json composer.lock package.json symfony.lock webpack.config.js yarn.lock ./

RUN composer install --prefer-dist --no-scripts --no-progress --no-suggest \
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

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/prod.ini $PHP_INI_DIR/conf.d/prod.ini

FROM php_build as php_build_assets
RUN apk add --no-cache \
  nodejs \
  npm \
  yarn
COPY assets assets/
RUN yarn install \
  && yarn encore production

FROM php_build as php_build_final
COPY --from=php_build_assets /var/www/html/public/build /var/www/html/public/build

STOPSIGNAL SIGQUIT
EXPOSE 9000
CMD ["php-fpm"]
