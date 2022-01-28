FROM php:8.0.12-apache-buster
MAINTAINER Mussa Athumani Matola <mathumani@assemble.co.tz>
RUN apt-get update && docker-php-ext-install pdo_mysql && a2enmod rewrite
RUN sed -ri 's/upload_max_filesize = 2M/upload_max_filesize = 10M/g' ${PHP_INI_DIR}/php.ini-production
RUN sed -ri 's/upload_max_filesize = 2M/upload_max_filesize = 10M/g' ${PHP_INI_DIR}/php.ini-development
RUN mkdir /etc/apache2/ssl && ln -s /etc/apache2/mods-available/ssl.load /etc/apache2/mods-enabled 
COPY ssl /etc/apache2/ssl
RUN sed -ri 's/etc\/ssl\/certs\/ssl-cert-snakeoil.pem/etc\/apache2\/ssl\/ssl.crt/g' /etc/apache2/sites-available/default-ssl.conf
RUN sed -ri 's/etc\/ssl\/private\/ssl-cert-snakeoil.key/etc\/apache2\/ssl\/ssl.key/g' /etc/apache2/sites-available/default-ssl.conf
RUN a2ensite default-ssl.conf

EXPOSE 443
RUN cp ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini
