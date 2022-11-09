FROM php:8.1-fpm

# Fix debconf warnings upon .build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
        locales \
        libzip-dev \
        zip \
        unzip \
        p7zip-full \
    && docker-php-ext-install zip opcache mysqli pdo pdo_mysql


# Install PHP Redis extension
RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the locale
RUN sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

COPY www.conf /usr/local/etc/php-fpm.d
COPY opcache.ini "$PHP_INI_DIR"/conf.d
COPY php.ini "$PHP_INI_DIR"/conf.d

WORKDIR "/application"
