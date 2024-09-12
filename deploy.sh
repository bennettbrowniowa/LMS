#!/bin/bash

# Navigate to your project directory
cd /home/inextwebs/public_html/newlms.inextwebs.com || { echo "Failed to change directory"; exit 1; }

# Set correct file permissions for deploy.sh itself
chmod 755 /home/inextwebs/public_html/newlms.inextwebs.com/deploy.sh || { echo "Failed to set deploy.sh permissions"; exit 1; }

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

# Set proper file permissions for the project
chown -R inextwebs:inextwebs /home/inextwebs/public_html/newlms.inextwebs.com || { echo "Chown failed"; exit 1; }

echo "Deployment completed successfully"

