FROM php:8.2-fpm AS base

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}
ENV PHP_USER=laravel

WORKDIR /var/www/html

RUN groupadd -g ${GID} ${PHP_USER} && \
    useradd -u ${UID} -g ${GID} -m ${PHP_USER} && \
    sed -i -E "s/^(user|group) = www-data/\1 = ${PHP_USER}/g" /usr/local/etc/php-fpm.d/www.conf

RUN apt-get update && apt-get install -y \
    inkscape \
    imagemagick \
    libmagickwand-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    git

RUN pecl install imagick 6.9

RUN docker-php-ext-enable \
    imagick

RUN docker-php-ext-install \
    zip \
    gd \
    pdo \
    pdo_mysql

FROM base AS composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer
USER ${PHP_USER}
ENTRYPOINT ["composer"]

FROM base AS artisan
USER ${PHP_USER}
ENTRYPOINT ["php", "/var/www/html/artisan"]

FROM base AS app
USER ${PHP_USER}
CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
