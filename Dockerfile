FROM php:8.2-apache

# تغيير منفذ Apache الافتراضي ليطابق المنفذ المتوقع في رندر
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf

COPY . /var/www/html/

EXPOSE 10000
