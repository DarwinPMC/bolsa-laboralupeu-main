FROM php:8.3.7-fpm-alpine
RUN apk add --no-cache linux-headers

# Actualización y adición de paquetes necesarios
RUN apk --no-cache upgrade && \
    apk add bash git sudo openssh libxml2-dev oniguruma-dev autoconf gcc g++ make npm freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev

# PHP: Instalar extensiones de PHP
RUN pecl channel-update pecl.php.net
RUN pecl install pcov swoole
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instalación de la extensión pcntl para manejar señales del sistema
RUN docker-php-ext-install pcntl mbstring xml gd zip sockets pdo pdo_mysql bcmath soap
RUN docker-php-ext-enable mbstring xml gd zip pcov pdo_mysql soap swoole

# Instalación de más extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install mysqli pdo pdo_mysql intl

# Instalación de Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Copiar binario de Composer y RoadRunner
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

# Habilitar las funciones pcntl_* en php.ini
RUN echo "disable_functions=" >> /usr/local/etc/php/php.ini

# Configuración del directorio de trabajo
WORKDIR /app
COPY . .

# Instalación de dependencias de Composer y Laravel Octane
RUN composer install
RUN composer require laravel/octane spiral/roadrunner

# Copia de archivos necesarios y creación de directorios
COPY .env .env
RUN mkdir -p /app/storage/logs

# Instalación de Octane con el servidor Swoole
RUN php artisan octane:install --server="swoole"

# Comando por defecto para iniciar Octane con Swoole
CMD php artisan octane:start --server="swoole" --host="0.0.0.0"

# Exponer el puerto 8000
EXPOSE 8000
