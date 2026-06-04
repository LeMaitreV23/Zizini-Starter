# Beginner VPS Deployment: Zizini

Target domain: `test.zizini.co.ke`

## 1. Upload The Zip

1. Open Bitvise.
2. Connect to the Ubuntu VPS.
3. Open the SFTP window.
4. Upload `zizini-deploy.zip` to:

```text
/var/www/zizini-deploy.zip
```

## 2. Unzip On The Server

In the Bitvise terminal:

```bash
sudo mkdir -p /var/www/zizini
sudo unzip -o /var/www/zizini-deploy.zip -d /var/www/zizini
sudo chown -R www-data:www-data /var/www/zizini
```

## 3. Install Server Packages

```bash
sudo apt update
sudo apt install -y nginx postgresql postgresql-contrib unzip curl php php-cli php-fpm php-pgsql php-mbstring php-xml php-curl php-zip php-bcmath php-fileinfo composer
```

## 4. Create PostgreSQL Database

```bash
sudo -u postgres psql
```

Inside PostgreSQL:

```sql
CREATE DATABASE zizini;
CREATE USER zizini_user WITH ENCRYPTED PASSWORD 'CHANGE_THIS_PASSWORD';
GRANT ALL PRIVILEGES ON DATABASE zizini TO zizini_user;
\q
```

## 5. Create Production `.env`

```bash
cd /var/www/zizini
sudo cp .env.example .env
sudo nano .env
```

Use these important values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://test.zizini.co.ke

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=zizini
DB_USERNAME=zizini_user
DB_PASSWORD=CHANGE_THIS_PASSWORD
```

## 6. Prepare Laravel

```bash
cd /var/www/zizini
sudo composer install --no-dev --optimize-autoloader
sudo php artisan key:generate
sudo php artisan migrate --seed
sudo php artisan storage:link
sudo php artisan config:cache
sudo php artisan route:cache
sudo php artisan view:cache
sudo chown -R www-data:www-data /var/www/zizini
```

## 7. Web Server

Point the web server document root to:

```text
/var/www/zizini/public
```

Do not point Nginx or Apache to `/var/www/zizini`; it must point to the `public` folder.

## 8. Test

Open:

```text
https://test.zizini.co.ke
```

Test:

- Public marketplace
- Seller login
- Admin login
- Admin dashboard
- Seller dashboard
- Listing detail pages
