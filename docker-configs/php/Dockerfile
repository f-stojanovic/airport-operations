FROM php:7.3-fpm

MAINTAINER Vaskevich Yevgeniy <wbrframe@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    wget

# Installing Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

# Installing PHP extensions
RUN docker-php-ext-install intl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql

# Installing xdebug
RUN pecl install xdebug-2.7.1

WORKDIR /app

# Creating custom user `guest` with same uid, gid and groups as Host machine
ENV user guest
RUN useradd -m -d /home/${user} ${user} && chown -R ${user} /home/${user}
RUN chown -R ${user} /app
USER ${user}
