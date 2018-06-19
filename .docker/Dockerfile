FROM php:7.1.8-apache

MAINTAINER Sviat Oleksiv

COPY . /var/www/html
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
# Installing git
RUN apt-get update
RUN apt-get install git-core
RUN git config --global user.name "Sviat Oleksiv"
RUN git config --global user.email hi.oleksiv@gmail.com