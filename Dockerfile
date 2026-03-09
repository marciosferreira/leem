# Imagem base oficial do PHP com Apache
FROM php:8.1-apache

# Instalamos as extensões para o PHP conectar no MySQL via rede interna
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos o Apache para processar rotas (importante para o seu rotas.php)
RUN a2enmod rewrite

# Copiamos seus arquivos (index.php, database.php, etc) para o diretório do servidor
COPY . /var/www/html/

# Ajustamos as permissões para o servidor web
RUN chown -R www-data:www-data /var/www/html/

# O Apache por padrão ouve na porta 80
EXPOSE 80