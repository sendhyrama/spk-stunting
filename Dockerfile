FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer --version=2.1.3
RUN docker-php-ext-install pdo_mysql mbstring

WORKDIR /app
COPY composer.json composer.lock /app/

# Install dependencies and generate autoloader
RUN composer update --no-scripts --no-autoloader \
    && composer install --no-scripts --no-autoloader \
    && composer dump-autoload --no-scripts --optimize

COPY . .

# Remove unnecessary dependencies
RUN apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
    && rm -rf /var/lib/apt/lists/*

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
