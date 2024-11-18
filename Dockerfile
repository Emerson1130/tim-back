FROM php:8.1-apache

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/html/

# Copy apache config
COPY .docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    zip \
    nano \
    libzip-dev \
    libpq-dev \
    unzip \
    libonig-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
# Clear cache
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure extensions for php
RUN docker-php-ext-configure gd

# Install extensions for php
RUN docker-php-ext-install pdo_mysql zip gd

# Enable apache modules
RUN a2enmod rewrite

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:cache && php artisan route:cache

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
    /var/www/html/vendor \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 80
CMD ["apache2-foreground"]
