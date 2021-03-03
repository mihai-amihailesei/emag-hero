FROM php:8.0-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

CMD ["php", "console", "emag:battle"]
