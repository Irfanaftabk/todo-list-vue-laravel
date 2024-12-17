# Quick Deployment Guide - Todo Application

## Prerequisites
- PHP 8.1+, Node.js 16+, MySQL 8.0+
- Nginx, Git, Composer

## Local Development

### Backend Setup
```bash
# Clone and setup backend
git clone <repository-url>
cd todo-backend
composer install
cp .env.example .env
php artisan key:generate

# Setup database
mysql -u root -p -e "CREATE DATABASE todo_app"
php artisan migrate --seed

# Start server
php artisan serve
```

### Frontend Setup
```bash
# Setup frontend
cd todo-frontend
npm install
cp .env.example .env  # Set VITE_API_BASE_URL=http://localhost:8000/api
npm run dev
```

## Production Deployment

### Server Setup
```bash
# Install requirements
sudo apt update && sudo apt upgrade
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql nodejs npm

# Setup MySQL
sudo mysql_secure_installation
mysql -u root -p -e "CREATE DATABASE todo_app; CREATE USER 'todo_user'@'localhost' IDENTIFIED BY 'your_password'; GRANT ALL ON todo_app.* TO 'todo_user'@'localhost';"
```

### Backend Deployment
```bash
# Clone and setup
cd /var/www
git clone <repository-url> todo-backend
cd todo-backend
composer install --no-dev
cp .env.example .env  # Configure environment variables
php artisan key:generate
php artisan migrate --force

# Set permissions
sudo chown -R www-data:www-data /var/www/todo-backend
sudo chmod -R 755 /var/www/todo-backend
sudo chmod -R 777 storage bootstrap/cache
```

### Frontend Deployment
```bash
# Clone and build
cd /var/www
git clone <repository-url> todo-frontend
cd todo-frontend
npm install
cp .env.example .env  # Set VITE_API_BASE_URL
npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/todo-frontend
sudo chmod -R 755 /var/www/todo-frontend
```

### Nginx Configuration

Backend (`/etc/nginx/sites-available/todo-backend`):
```nginx
server {
    listen 80;
    server_name api.your-domain.com;
    root /var/www/todo-backend/public;

    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Frontend (`/etc/nginx/sites-available/todo-frontend`):
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/todo-frontend/dist;

    index index.html;
    
    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

Enable sites:
```bash
sudo ln -s /etc/nginx/sites-available/todo-backend /etc/nginx/sites-enabled/
sudo ln -s /etc/nginx/sites-available/todo-frontend /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl restart nginx
```

### SSL Setup
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com -d api.your-domain.com
```

## Troubleshooting

Check logs:
```bash
# Nginx logs
sudo tail -f /var/log/nginx/error.log

# Laravel logs
tail -f /var/www/todo-backend/storage/logs/laravel.log

# Frontend console
Check browser developer tools
```