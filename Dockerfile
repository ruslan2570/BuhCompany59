FROM php:7.4-apache
RUN docker-php-ext-install mysqli json && docker-php-ext-enable mysqli json
RUN apt-get update && apt-get upgrade -y 