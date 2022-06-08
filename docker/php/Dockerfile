FROM php:7.4-fpm

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get -y install -qq openssh-client
RUN apt-get -y install -qq  --fix-missing -y libpq-dev
RUN apt-get -y install -qq  --no-install-recommends -y libpq-dev
RUN apt-get -y install -qq  libxml2-dev libbz2-dev zlib1g-dev
RUN apt-get -y install -qq libsqlite3-dev libsqlite3-0 mariadb-client curl exif ftp libcurl4 libcurl4-openssl-dev libzip-dev git libpq-dev
RUN docker-php-ext-install \
    pgsql \
    pdo_pgsql \
    pdo \
    curl \
    xml \
    bcmath \
    zip \
    json \
    intl \
    tokenizer


RUN pecl install redis-5.1.1 \
    && pecl install xdebug-2.8.1 \
    && docker-php-ext-enable redis xdebug

## Install gd for image creation/editing
RUN apt-get install -y vim libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer self-update

RUN apt-get clean \
    && rm -r /var/lib/apt/lists/*

WORKDIR /var/www3/
RUN chown -R www-data:www-data /var/www3/

RUN mkdir /var/www2/
RUN chown -R www-data:www-data /var/www2/

WORKDIR /var/www/
RUN chown -R www-data:www-data /var/www/


COPY bashrc /root/.bashrc

#   ENABLE IFCONFIG ON LOCAL APPLE MACHINE
# ifconfig lo0 alias 10.254.254.254
