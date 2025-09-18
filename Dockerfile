#Deploy Render

#FROM richarvey/nginx-php-fpm:3.1.6
#
#COPY . .
#
## Image config
#ENV SKIP_COMPOSER 1
#ENV WEBROOT /var/www/html/public
#ENV PHP_ERRORS_STDERR 1
#ENV RUN_SCRIPTS 1
#ENV REAL_IP_HEADER 1
#
## Laravel config
#ENV APP_ENV production
#ENV APP_DEBUG false
#ENV LOG_CHANNEL stderr
#
## Allow composer to run as root
#ENV COMPOSER_ALLOW_SUPERUSER 1
#
#CMD ["/start.sh"]

#Deploy Railway

# Imagem base do PHP com extensões comuns para Laravel
FROM php:8.2-cli

# Instalar dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências PHP (sem dev, otimizado)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Expor porta que o Railway espera
EXPOSE 8080

# Comando para rodar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

