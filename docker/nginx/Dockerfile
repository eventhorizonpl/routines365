FROM nginx:1.18.0-alpine as nginx_build

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html

FROM nginx_build as nginx_build_assets
COPY package.json webpack.config.js yarn.lock ./
RUN apk add --no-cache \
  nodejs \
  npm \
  yarn
COPY assets assets/
RUN yarn install \
  && yarn encore production

FROM nginx_build as nginx_build_final
COPY --from=nginx_build_assets /var/www/html/public/build /var/www/html/public/build
COPY public/humans.txt public/robots.txt public/sitemap.xml public/

STOPSIGNAL SIGQUIT
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
