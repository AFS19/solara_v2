#!/bin/bash
set -e

cd /var/www/html

# Run migrations
php artisan migrate --force

# Storage link
php artisan storage:link

# Cache config/route/views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
apache2-foreground
