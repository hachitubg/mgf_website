# Sử dụng PHP 8.1 với Apache
FROM php:8.1-apache

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy toàn bộ code vào container
COPY . /var/www/html/

# Set quyền cho thư mục uploads
RUN chown -R www-data:www-data /var/www/html/uploads && \
    chmod -R 755 /var/www/html/uploads

# Expose port 80
EXPOSE 80
