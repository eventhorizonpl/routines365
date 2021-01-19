#!/bin/sh

bin/console fos:js-routing:dump --target=public/bundles/fosjsrouting/js/fos_js_routes.js
yarn encore dev --watch
