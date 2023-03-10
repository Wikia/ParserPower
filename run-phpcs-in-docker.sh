#!/bin/sh
echo "Installs dependencies and runs code sniffer for project under php 7.4.33 in docker"
echo ""
docker run -t -v $(pwd):/var/www/project php:7.4.33-fpm-alpine3.16 /bin/sh -c " \
TERM=xterm-256color ls --color=auto \
&& cd /var/www/project \
&& (( [ ! -e composer.phar ] && php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\" && php composer-setup.php )) && unlink composer-setup.php || true \
&& php composer.phar install \
&& echo \"----- phpcs output -----\" \
&& php composer.phar test"
