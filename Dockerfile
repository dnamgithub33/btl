FROM php:8.0-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html
COPY ./ /var/www/html
RUN chmod 777 /var/www/html/btl/img/books

EXPOSE 80