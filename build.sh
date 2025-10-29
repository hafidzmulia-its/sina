#!/bin/bash

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
npm ci
npm run build

# Create necessary directories
mkdir -p /tmp

# Generate optimized class loader
php artisan optimize

echo "Build completed successfully!"