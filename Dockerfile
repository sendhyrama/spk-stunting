<<<<<<< HEAD
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
<<<<<<< HEAD
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer --version=2.1.3
>>>>>>> d3c9c263c70b690767ee3722242bbb965bcaa646
RUN docker-php-ext-install pdo_mysql mbstring

WORKDIR /app
COPY composer.json .
RUN composer install --no-scripts
COPY . .

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
