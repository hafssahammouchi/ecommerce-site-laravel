#!/usr/bin/env bash
set -e

# Render fournit PORT ; Apache doit écouter sur ce port
PORT="${PORT:-80}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

# Migrations et cache (variables .env fournies par Render)
echo "Running migrations..."
php artisan migrate --force --no-interaction || true

echo "Caching config..."
php artisan config:cache

echo "Starting Apache..."
exec apache2-foreground
