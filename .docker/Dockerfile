FROM php:8.1-apache AS development

RUN apt-get update && apt-get install -y wait-for-it libzip-dev zip gosu

RUN pecl install xdebug-3.1.4 && docker-php-ext-enable xdebug
RUN docker-php-ext-configure zip && docker-php-ext-install zip
RUN curl https://getcomposer.org/download/2.3.6/composer.phar --output /usr/bin/composer \
 && chmod +x /usr/bin/composer

COPY app.sh /app.sh
RUN chmod +x /app.sh

COPY php.ini /usr/local/etc/php/conf.d/zzz-nka.ini

ENTRYPOINT [ "/app.sh" ]
CMD [ "php", "artisan", "serve", "--host", "0.0.0.0" ]
