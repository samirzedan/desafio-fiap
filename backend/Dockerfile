FROM php:8.4-apache
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite headers
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
COPY ./ /var/www/html/
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
CMD ["apache2-foreground"]
