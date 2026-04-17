#!/bin/bash
set -e

SERVER_IP="195.35.6.35"
SERVER_USER="root"
REMOTE_DIR="/var/www/support.x1eventflow"
ZIP_NAME="deploy.zip"

START_TIME=$(date +%s)

show_timer() {
  while true; do
    NOW=$(date +%s)
    ELAPSED=$((NOW - START_TIME))
    MINUTES=$((ELAPSED / 60))
    SECONDS=$((ELAPSED % 60))
    printf "\r⏱ Deploy running... %02dm %02ds" "$MINUTES" "$SECONDS"
    sleep 1
  done
}

cleanup() {
  if [[ -n "$TIMER_PID" ]]; then
    kill "$TIMER_PID" 2>/dev/null || true
  fi
}

trap cleanup EXIT

echo "🚀 Starting deploy..."

cd "$(dirname "$0")"

show_timer &
TIMER_PID=$!

echo "📦 Creating ZIP..."
rm -f "$ZIP_NAME"

zip -r "$ZIP_NAME" . \
  -x ".git/*" \
  -x ".env" \
  -x "database/database.sqlite" \
  -x "storage/*" \
  -x "vendor/*" \
  -x "node_modules/*" \
  -x "bootstrap/cache/*" \
  > /dev/null

echo "📤 Uploading..."
scp "$ZIP_NAME" "${SERVER_USER}@${SERVER_IP}:${REMOTE_DIR}/"

echo "🛠 Deploying on server..."
ssh "${SERVER_USER}@${SERVER_IP}" "cd ${REMOTE_DIR} && ./deploy.sh"

cleanup
echo ""

END_TIME=$(date +%s)
DURATION=$((END_TIME - START_TIME))
MINUTES=$((DURATION / 60))
SECONDS=$((DURATION % 60))

echo "✅ DONE"
echo "⏱ Duration: ${MINUTES}m ${SECONDS}s"
