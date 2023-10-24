FROM php:7.4-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    build-essential \
    curl

COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install bcmath

EXPOSE 9000
CMD ["php-fpm"]