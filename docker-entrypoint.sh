#!/bin/bash

# Wait for database to be ready
echo "Waiting for database to be ready..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, waiting 5 seconds..."
    sleep 5
done

# Run migrations if needed
echo "Running migrations..."
php artisan migrate --force

# Generate app key if not exists
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear cache
echo "Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage link if not exists
if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link
fi

# Seed database if SEED_DATABASE is true
if [ "$SEED_DATABASE" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

echo "Starting Apache..."
exec apache2-foreground