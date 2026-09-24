# 1. gunakan image dasar php versi CLI
FROM php:8.4-cli

# 2. install dependensi sistem dasar dan ekstensi PHP
COPY apt-get update && apt-get install -y libzip-dev xip unzip && docker-php-ext-install pdo_mysql zip

# 3. install composer 
COPY --from=composer:latest /user/bin/composer /usr/bin/composer

# 4. tetapkan direktori kerja utama di dalam container
WORKDIR /var/www