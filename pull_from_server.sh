#!/bin/bash
set -e

SERVER="root@195.35.6.35"
REMOTE_DIR="/var/www/support.x1eventflow"

echo "==> Pull database from server..."
mkdir -p database
cp database/database.sqlite database/database-local-backup-$(date +%F-%H%M%S).sqlite 2>/dev/null || true
scp ${SERVER}:${REMOTE_DIR}/database/database.sqlite database/database.sqlite

echo "==> Pull uploaded files..."
mkdir -p storage/app/public/photos
mkdir -p storage/app/public/problem-photos
rsync -avz ${SERVER}:${REMOTE_DIR}/storage/app/public/photos/ storage/app/public/photos/ || true
rsync -avz ${SERVER}:${REMOTE_DIR}/storage/app/public/problem-photos/ storage/app/public/problem-photos/ || true

echo "==> Pull code from server..."
rsync -avz \
  --exclude ".git" \
  --exclude "vendor" \
  --exclude "node_modules" \
  --exclude ".env" \
  --exclude "database/database.sqlite" \
  --exclude "storage" \
  --exclude "bootstrap/cache" \
  ${SERVER}:${REMOTE_DIR}/ ./

rm -rf public/storage
php artisan storage:link
php artisan optimize:clear

echo "PULL COMPLETE"
