FROM php:8.1-apache
# This line is crucial for connecting to MySQL
RUN docker-php-ext-install mysqli
# Copy all files to the web root
COPY . /var/www/html/
# Ensure permissions are correct
RUN chown -R www-data:www-data /var/www/html