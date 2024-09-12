#!/bin/bash

# Navigate to your project directory
cd /home/inextwebs/public_html/newlms.inextwebs.com || { echo "Failed to change directory"; exit 1; }

# Configure Git to handle divergent branches
git config pull.rebase false  # or true based on your preference

# Pull the latest changes from Git
git pull origin main || { echo "Git pull failed"; exit 1; }

# Run migrations if needed
php artisan migrate --force || { echo "Migrations failed"; exit 1; }

# Clear caches (config, routes, views)
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Temporarily disable cache commands to avoid closure issues, uncomment once fixed
# php artisan config:cache || { echo "Config cache failed"; exit 1; }
# php artisan route:cache || { echo "Route cache failed"; exit 1; }
# php artisan view:cache || { echo "View cache failed"; exit 1; }

# Set proper file permissions (adjust as necessary)
chown -R inextwebs:inextwebs /home/inextwebs/public_html/newlms.inextwebs.com || { echo "Chown failed"; exit 1; }

echo "Deployment completed successfully"

