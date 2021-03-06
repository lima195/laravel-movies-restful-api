FROM php:7.4-fpm

RUN useradd -m john && echo "john:john" | chpasswd && adduser john sudo && adduser john www-data

ARG DEBIAN_FRONTEND=noninteractive

ENV HOME /home/john

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

# Get repository and install wget and vim
RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        apt-utils \
        unzip

# Install PHP extensions deps
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        unixodbc-dev \
        libxml2-dev \
        libaio-dev \
        freetds-dev \
		libssl-dev \
        libxslt-dev \
        libwebp-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
		openssl

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install \
            iconv \
            mbstring \
            bcmath \
            xsl \
            intl \
            gd \
            mysqli \
            pdo_mysql \
            soap \
            zip \
            xmlrpc \
            opcache 

RUN apt-get update && apt-get install -y 
RUN pecl install mcrypt-1.0.3
RUN docker-php-ext-enable mcrypt
RUN docker-php-ext-enable bcmath

# Install Xdebug
RUN apt-get update \
    && pecl install -f xdebug \
    && docker-php-ext-enable xdebug

# Clean repository
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer version 1.10.19
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update 1.10.19 \
    && composer global require hirak/prestissimo --no-plugins --no-scripts

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets

## Fixing owner permissions
RUN chown -R john:john $HOME

USER john
