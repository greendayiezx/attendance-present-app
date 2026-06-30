FROM php:8.2-cli

# Install system dependencies and Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions easily using mlocati/docker-php-extension-installer
# This script automatically installs the required APT dependencies for each PHP extension
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first (for layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy package files
COPY package.json package-lock.json* ./

# Install Node dependencies
RUN npm ci || npm install

# Copy all application files
COPY . .

# Finish composer autoload
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

CMD sh -c "php artisan config:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port ${PORT:-8080}"
