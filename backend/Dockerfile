# Use uma imagem base oficial do PHP com Apache
FROM php:8.2-apache

# Instale extensões necessárias do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instale Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do projeto para o contêiner
COPY . .

# Instale as dependências do Laravel
RUN composer install

# Dê permissão de escrita para o diretório de armazenamento
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta 80
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["apache2-foreground"] 