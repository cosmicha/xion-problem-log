#!/bin/bash
set -e

SERVER="root@195.35.6.35"
REMOTE_DIR="/var/www/support.x1eventflow"

echo "==> Sync code to server with rsync..."
rsync -avz --delete \
  --exclude ".git" \
  --exclude "vendor" \
  --exclude "node_modules" \
  --exclude ".env" \
  --exclude "database/database.sqlite" \
  --exclude "storage" \
  --exclude "bootstrap/cache" \
  ./ ${SERVER}:${REMOTE_DIR}/

echo "==> Run post-deploy commands on server..."
ssh ${SERVER} << 'EOF'
set -e
cd /var/www/support.x1eventflow

cp database/database.sqlite database/database-backup-$(date +%F-%H%M%S).sqlite

composer install --no-dev --optimize-autoloader
php artisan migrate --force

mkdir -p storage/logs
chown -R www-data:www-data /var/www/support.x1eventflow
chmod -R 775 storage bootstrap/cache public

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan queue:restart
systemctl restart x1eventflow-worker

echo "SAFE RSYNC DEPLOY COMPLETE"
EOF
