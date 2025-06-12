FROM php:8.2-apache

# Aktifkan modul rewrite jika kamu menggunakan .htaccess (opsional)
RUN a2enmod rewrite

# Install ekstensi mysqli (PENTING untuk koneksi ke MySQL)
RUN docker-php-ext-install mysqli

# Copy semua file project ke direktori web server
COPY . /var/www/html/

# Pastikan permission file upload (opsional)
RUN chmod -R 755 /var/www/html/uploads

# Expose port 80 untuk web
EXPOSE 80
