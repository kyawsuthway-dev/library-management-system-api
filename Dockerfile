FROM php:8.2.14-fpm-bullseye

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install supervisor
RUN apt-get update && apt-get install -y supervisor zip unzip git curl

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
  install-php-extensions mcrypt bcmath zip gd intl pdo pdo_pgsql pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Create a non-root user
RUN groupadd -g 1000 laravel \
  && useradd -u 1000 -g laravel -m -s /bin/bash laravel

# Set workdir to www
WORKDIR /var/www/html

# Copy laravel files
COPY --chown=laravel:www-data . .

USER laravel