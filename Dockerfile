FROM clockwise/docker-phpunit-alpain:fpm

COPY ./deploy/php.ini /usr/local/etc/php

RUN docker-php-ext-install exif \
    && docker-php-ext-enable exif

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN mkdir /etc/periodic/everymin
COPY ./deploy/schedule /etc/periodic/everymin/schedule
RUN chmod +x /etc/periodic/everymin/schedule
RUN echo -e "*       *       *       *       *       run-parts /etc/periodic/everymin\n" >> /etc/crontabs/root

RUN apk update && apk add --no-cache supervisor
COPY ./deploy/supervisord.conf /etc/supervisord.conf

CMD ["sh", "docker.sh"]
