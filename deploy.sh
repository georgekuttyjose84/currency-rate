#!/bin/bash
set -e

echo "Starting deployment..."

cd /home/deploy/marketniro-app

PREVIOUS_COMMIT=$(git rev-parse HEAD)

echo "Pulling latest code..."
git fetch origin
git reset --hard origin/main

echo "Rebuilding containers..."
docker compose down
docker compose up -d --build

echo "Deployment completed successfully."
