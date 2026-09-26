
#!/usr/bin/env bash
set -euo pipefail

REPO="$HOME/dentalcare-repo"
APP="$HOME/dentalcare"
WEB="$HOME/public_html"

echo "Starting DentalCare deployment..."

cd "$REPO"

# Perbarui repository
git fetch origin main
git checkout main
git pull --ff-only origin main

# Periksa persyaratan deployment
command -v rsync
test -f "$APP/.env"
test -d "$APP/storage"
test -f "$HOME/frontend-build.tar.gz"

# Siapkan hasil build dari GitHub Actions
mkdir -p "$REPO/public"
tar -xzf "$HOME/frontend-build.tar.gz" -C "$REPO/public"
test -f "$REPO/public/build/manifest.json"

# Salin kode tanpa menimpa konfigurasi dan data produksi
rsync -a \
  --exclude='.git/' \
  --exclude='.env' \
  --exclude='storage/' \
  --exclude='vendor/' \
  --exclude='node_modules/' \
  --exclude='public/build/' \
  "$REPO/" "$APP/"

# Hapus controller lama yang telah dihapus dari Git
rm -f "$APP/app/Http/Controllers/AppointmentController.php"

# Instal dependensi PHP
cd "$APP"

composer install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --optimize-autoloader

# Perbarui aset Vite di kedua lokasi
rsync -a --delete \
  "$REPO/public/build/" "$APP/public/build/"

rsync -a --delete \
  "$REPO/public/build/" "$WEB/build/"

# Bersihkan dan bangun ulang cache Laravel
php artisan optimize:clear
php artisan optimize

# Tampilkan status migrasi, tanpa mengubah database
php artisan migrate:status

rm -f "$HOME/frontend-build.tar.gz"

echo "DentalCare deployment completed."
