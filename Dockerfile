FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first (for layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy package files
COPY package.json ./

# Install Node dependencies
RUN npm install

# Copy all application files
COPY . .

# Finish composer autoload
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

CMD sh -c "php artisan config:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port ${PORT:-8080}"
