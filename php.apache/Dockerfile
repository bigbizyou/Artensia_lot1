#FROM php:7.4-apache
#FROM php:8.0-apache
FROM php:8.1-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libjpeg-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip nodejs npm yarn -y;

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
# RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | /etc/apt/sources.list.d/yarn.list
# RUN apt-get update && sudo apt-get install -y yarn

# Install Oracle Instantclient
RUN apt-get install libaio1 libaio-dev
RUN apt-get install -y wget

RUN mkdir -p /opt/oracle/

RUN wget https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-basic-linux.x64-12.1.0.2.0.zip -O /opt/oracle/instantclient-basic-linux.x64-12.1.0.2.0.zip
RUN wget https://github.com/pwnlabs/oracle-instantclient/raw/master/instantclient-sdk-linux.x64-12.1.0.2.0.zip -O /opt/oracle/instantclient-sdk-linux.x64-12.1.0.2.0.zip

# ADD instantclient-basic-linux.x64-12.1.0.2.0.zip /opt/oracle/instantclient-basic-linux.x64-12.1.0.2.0.zip
# ADD instantclient-sdk-linux.x64-12.1.0.2.0.zip /opt/oracle/instantclient-sdk-linux.x64-12.1.0.2.0.zip
RUN unzip /opt/oracle/instantclient-basic-linux.x64-12.1.0.2.0.zip -d /opt/oracle \
    && unzip /opt/oracle/instantclient-sdk-linux.x64-12.1.0.2.0.zip -d /opt/oracle \
    && ln -s /opt/oracle/instantclient_12_1/libclntsh.so.12.1 /opt/oracle/instantclient_12_1/libclntsh.so \
    && ln -s /opt/oracle/instantclient_12_1/libclntshcore.so.12.1 /opt/oracle/instantclient_12_1/libclntshcore.so \
    && ln -s /opt/oracle/instantclient_12_1/libocci.so.12.1 /opt/oracle/instantclient_12_1/libocci.so \
    && rm -rf /opt/oracle/*.zip

ENV LD_LIBRARY_PATH  /opt/oracle/instantclient_12_1:${LD_LIBRARY_PATH}

RUN echo 'instantclient,/opt/oracle/instantclient_12_1/' | pecl install oci8 \ 
      && docker-php-ext-enable \
               oci8 \ 
       && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient_12_1/ \
       && docker-php-ext-install \
               pdo_oci 



# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
COPY conf/php.ini /usr/local/etc/php/php.ini



# Apache
COPY errors /errorss
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf
#COPY index.php /app/index.php

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient_12_1/
RUN docker-php-ext-install pdo pdo_mysql opcache intl zip calendar dom mbstring zip gd xsl exif fileinfo
RUN pecl install apcu && docker-php-ext-enable apcu



WORKDIR /var/www/

RUN a2enmod ssl && \
    a2enmod rewrite remoteip && \
    a2enconf z-app

