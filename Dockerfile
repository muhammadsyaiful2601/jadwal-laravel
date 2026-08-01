# Gunakan image PHP 8.2 dengan Apache server
FROM php:8.2-apache

# Install ekstensi sistem operasi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Aktifkan fitur URL rewrite Apache (penting untuk routing Laravel)
RUN a2enmod rewrite

# Arahkan root folder web ke direktori /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Pindahkan semua file proyek Anda ke dalam container server
COPY . /var/www/html

# Atur lokasi kerja terminal di dalam server
WORKDIR /var/www/html

# Ambil dan install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Jalankan instalasi library Laravel (abaikan library untuk development)
RUN composer install --no-dev --optimize-autoloader

# Berikan hak akses (permission) agar Laravel bisa menulis file log dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache