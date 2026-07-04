FROM php:8.2-apache

# install ekstensi yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# enable rewrite
RUN a2enmod rewrite

# set working dir
WORKDIR /var/www/html

# copy project
COPY . .

# permissions
RUN chown -R www-data:www-data /var/www/html

# apache document root ke public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80