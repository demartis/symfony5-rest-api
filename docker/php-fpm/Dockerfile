FROM php:fpm-alpine

RUN apk --update --no-cache add git sqlite-dev wget bash
RUN wget https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -O /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
RUN docker-php-ext-install pdo_mysql pdo_sqlite
RUN docker-php-ext-enable opcache
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install; wait-for-it db:3306 -- bin/console doctrine:migrations:migrate; php-fpm
EXPOSE 9000