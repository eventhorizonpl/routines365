#FROM php:7.4-fpm-alpine AS php_build
FROM php:7.4-apache AS php_build

RUN apt-get update && apt-get install -y \
  acl \
  gnupg2 \
  libicu-dev \
  libxslt1-dev \
  libzip-dev \
  unzip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

#RUN apk add --no-cache \
#  libxslt \
#  libzip \
#  nginx \
#  zlib
#RUN apk add --no-cache --virtual .build-deps \
#  $PHPIZE_DEPS \
#  libxslt-dev \
#  libzip-dev \
#  zlib-dev

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

#RUN rm -rf /tmp/pear/
#RUN apk del .build-deps

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

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

FROM php_build as php_build_assets

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
  && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
  && apt-get update && apt-get install -y nodejs npm yarn

#RUN apk add --no-cache \
#  nodejs \
#  npm \
#  yarn

COPY assets assets/
RUN yarn install \
  && yarn encore production

FROM php_build as php_build_final
COPY --from=php_build_assets /var/www/html/public/build /var/www/html/public/build
COPY public/.htaccess public/robots.txt public/sitemap.xml public/
RUN chown -R www-data:www-data /var/www

#COPY docker/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/apache2/sites-enabled/routines365.conf /etc/apache2/sites-enabled/
COPY docker/php/conf.d/prod.ini $PHP_INI_DIR/conf.d/prod.ini
#COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf \
  && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && a2enmod expires \
  && a2enmod rewrite

#RUN mkdir -p /run/nginx/

EXPOSE 80

#STOPSIGNAL SIGTERM

#CMD ["nginx", "-g", "daemon off;"]

CMD ["apache2-foreground"]
