# Use the official PHP image as a base image
FROM php:8.2-fpm

# Set the working directory inside the container
WORKDIR /var/www/app

# Install system dependencies
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  unzip \
  nodejs \
  npm \
  git \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd zip pdo pdo_mysql

RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code into the container
COPY . ./

# Install PHP dependencies (will be cached if composer files haven't changed)
RUN composer install --no-dev --no-interaction --no-scripts --optimize-autoloader

# Run composer scripts after copying all files
RUN composer run-script post-autoload-dump

# Install Node.js dependencies
RUN npm install

# Build frontend assets
RUN npm run prod

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
