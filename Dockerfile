FROM richarvey/nginx-php-fpm:latest

# Define o diretório de trabalho correto
WORKDIR /var/www/html

# Copia apenas o código da aplicação para dentro do container
COPY . .

# Configurações da imagem
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Configurações do Laravel
ENV APP_ENV staging
ENV APP_DEBUG true
ENV LOG_CHANNEL stderr

# Permite rodar o composer como root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Render precisa expor a porta 10000
EXPOSE 10000

# Usa o script original da imagem base (não sobrescreve mais)
CMD ["/start.sh"]
