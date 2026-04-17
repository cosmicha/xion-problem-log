#!/usr/bin/env bash
set -e
ssh root@195.35.6.35 'cd /var/www/support.x1eventflow && ./deploy-safe.sh'
