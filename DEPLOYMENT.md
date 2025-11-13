# 🚀 Panduan Deployment

## Deployment ke Production

### 1. Persiapan Server

**Requirements:**
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/MariaDB
- Nginx/Apache

### 2. Clone & Install

```bash
git clone <repository-url> scholar-system
cd scholar-system

composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Environment Production

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=scholar_db
DB_USERNAME=scholar_user
DB_PASSWORD=your_secure_password

SESSION_DRIVER=database
CACHE_STORE=redis
QUEUE_CONNECTION=redis
```

### 4. Database

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### 5. Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 7. Nginx Config

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/scholar-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 8. SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

### 9. Queue Worker (Supervisor)

File: `/etc/supervisor/conf.d/scholar-worker.conf`

```ini
[program:scholar-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/scholar-system/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/scholar-system/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start scholar-worker:*
```

### 10. Cron Job

```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /var/www/scholar-system && php artisan schedule:run >> /dev/null 2>&1
```

---

## Deployment ke Shared Hosting

### 1. Build Assets Lokal

```bash
npm run build
```

### 2. Upload Files

Upload semua file kecuali:
- `node_modules/`
- `.git/`
- `.env`

### 3. Setup .env

Buat `.env` di server dengan konfigurasi hosting

### 4. Composer Install

```bash
composer install --optimize-autoloader --no-dev
```

### 5. Symlink Public

Jika root web di `public_html`:
```bash
ln -s /home/user/scholar-system/public/* /home/user/public_html/
```

Atau edit `.htaccess` di `public_html`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ /scholar-system/public/$1 [L]
</IfModule>
```

---

## Update Sitemap URL

Edit `public/robots.txt`:
```
Sitemap: https://yourdomain.com/sitemap.xml
```

Edit `app/Http/Controllers/SitemapController.php`:
```php
$sitemap .= '<loc>' . config('app.url') . '/artikel/' . $article->slug . '</loc>';
```

---

## Submit ke Google Scholar

1. Pastikan artikel sudah live dan publik
2. Cek metadata dengan: https://validator.schema.org/
3. Submit sitemap ke Google Search Console
4. Tunggu crawler Google Scholar (bisa 1-4 minggu)
5. Cek indeks: `site:yourdomain.com` di Google Scholar

---

## Monitoring

### Logs
```bash
tail -f storage/logs/laravel.log
```

### Performance
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Backup Database
```bash
php artisan backup:run
# atau
mysqldump -u user -p scholar_db > backup.sql
```

---

## Security Checklist

- [ ] APP_DEBUG=false di production
- [ ] APP_KEY sudah di-generate
- [ ] Database password kuat
- [ ] SSL/HTTPS aktif
- [ ] File permissions benar (755/644)
- [ ] .env tidak ter-commit ke git
- [ ] CORS dikonfigurasi dengan benar
- [ ] Rate limiting aktif
- [ ] Firewall dikonfigurasi
- [ ] Backup otomatis berjalan

---

Selamat! Aplikasi Anda siap production 🎉
