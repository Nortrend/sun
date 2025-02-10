FROM php:8.2-fpm

# Установите необходимые расширения
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Установите Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Скопируйте приложение в контейнер
WORKDIR /var/www
COPY ../.. .

# Установите зависимости Composer
RUN composer install

# Установите права доступа
RUN chown -R www-data:www-data /var/www

# Установка расширения MySQL
RUN docker-php-ext-install pdo_mysql

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Установка Node.js 18.x
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Запустите PHP-FPM
CMD ["php-fpm"]
