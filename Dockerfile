# Use the latest PHP 8.3 FPM image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev

# Install PHP extensions needed for Symfony
RUN docker-php-ext-install pdo pdo_mysql intl

# Install Opcache
RUN docker-php-ext-install opcache

# Opcache Configuration
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Set the working directory
WORKDIR /var/www/html

# Copy the application code into the container
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Rename .env.docker to .env inside the container
COPY .env /var/www/html/.env

# Install application dependencies
RUN composer install --no-scripts --no-interaction --optimize-autoloader

# Ensure correct file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Run migrations and then start PHP-FPM
CMD php bin/console doctrine:migrations:migrate --no-interaction && php-fpm