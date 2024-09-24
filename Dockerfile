# Usar a imagem base do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mbstring xml

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar o diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto para o contêiner
COPY src/ .

# Instalar dependências do Laravel
RUN composer install

# Definir permissões após instalar dependências
RUN composer install --prefer-dist --no-scripts --no-autoloader && \
    composer dump-autoload --optimize && \
    chown -R www-data:www-data /var/www/vendor && \
    chown -R www-data:www-data /var/www/.env


# Expor a porta 9000
EXPOSE 9000

# Usar o PHP-FPM como entrada
CMD ["php-fpm"]
