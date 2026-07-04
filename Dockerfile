FROM php:8.2-fpm-alpine

# Install extension PHP yang dibutuhkan Laravel & Nginx
RUN apk add --no-cache nginx wget bash \
    && docker-php-ext-install pdo pdo_mysql

# Copy konfigurasi custom Nginx agar langsung menembak folder public
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        try_files $uri =404; \
        fastcgi_split_path_info ^(.+\.php)(/.+)$; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        fastcgi_param PATH_INFO $fastcgi_path_info; \
    } \
}' > /etc/nginx/http.d/default.conf

# Set working directory
WORKDIR /var/www/html

# Copy semua file proyek
COPY . .

# Buat folder dan set permission agar tidak terkunci
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# Jalankan PHP-FPM dan Nginx sekaligus tanpa bentrok MPM
CMD php-fpm -D && nginx -g "daemon off;"