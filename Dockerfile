# Sử dụng PHP 8.1 với Apache
FROM php:8.1-apache

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Cấu hình Apache để xử lý PHP và cho phép truy cập
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php index.html\n\
</Directory>\n\
\n\
<FilesMatch \.php$>\n\
    SetHandler application/x-httpd-php\n\
</FilesMatch>' > /etc/apache2/conf-available/docker-php.conf \
    && a2enconf docker-php

# Copy toàn bộ code vào container
COPY . /var/www/html/

# Set quyền cho toàn bộ thư mục
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80
