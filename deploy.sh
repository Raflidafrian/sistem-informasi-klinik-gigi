
#!/usr/bin/env bash
set -euo pipefail

echo "Deploying DentalCare..."

git fetch origin main
git checkout main
git pull --ff-only origin main

composer install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --optimize-autoloader

npm ci
npm run build

php artisan migrate --force
php artisan optimize:clear
php artisan optimize
php artisan queue:restart

echo "DentalCare deployment completed."