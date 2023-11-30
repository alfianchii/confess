FROM php:8.2.8-fpm-alpine

# environment arguments
ARG UID
ARG GID
ARG USER

ENV UID=${UID}
ENV GID=${GID}
ENV USER=${USER}

# Dialout group in Alpine Linux conflicts with MacOS staff group's gid, which is 20
RUN delgroup dialout

# Creating user and group
RUN addgroup -g ${GID} --system ${USER}
RUN adduser -G ${USER} --system -D -s /bin/sh -u ${UID} ${USER}

# Modify php-fpm configuration to use the new user's privileges
RUN sed -i "s/user = www-data/user = '${USER}'/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = '${USER}'/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

# Install libs and extensions
RUN apk update && apk upgrade
RUN apk add --no-cache freetype freetype-dev \
  libpng libpng-dev \
  libjpeg-turbo libjpeg-turbo-dev \
  libwebp libwebp-dev \
  curl curl-dev \
  libzip-dev postgresql-dev oniguruma-dev
RUN docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-freetype 
RUN docker-php-ext-install pdo pdo_mysql bcmath pgsql pdo_pgsql mysqli gd curl zip mbstring
RUN docker-php-ext-enable mysqli

# Copies PHP configurations to override the default
ADD ./php/php.ini /usr/local/etc/php/conf.d/php.ini

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]