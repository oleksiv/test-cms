FROM php:7.1.8-apache

MAINTAINER Sviat Oleksiv

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y git
RUN apt-get install zip unzip

RUN a2enmod rewrite
RUN service apache2 restart
