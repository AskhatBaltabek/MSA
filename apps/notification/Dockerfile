FROM php:7.4-fpm-alpine

# Set working directory
WORKDIR /var/www/notification

# Install Additional dependencies
RUN apk update && apk add --no-cache \
    build-base shadow supervisor \
    libxml2-dev \
    php7-common \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-mcrypt \
    php7-mbstring \
    php7-xml \
    php7-openssl \
    php7-json \
    php7-phar \
    php7-zip \
    php7-gd \
    php7-dom \
    php7-session \
    php7-zlib \
    php7-soap

# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install soap
RUN docker-php-ext-install bcmath

# Remove Cache
RUN rm -rf /var/cache/apk/*


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY .docker/supervisord.conf /etc/supervisord.conf
COPY .docker/supervisor.d /etc/supervisor.d

# Use the default production configuration ($PHP_INI_DIR variable already set by the default image)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory contents
#COPY . /var/www/notification
COPY . .

# Copy existing application directory permissions
#COPY --chown=www-data:www-data . /var/www/notification

#ADD . /var/www/notification
RUN chmod -R 777 storage
RUN composer install
RUN chown -R www-data:www-data .

ENV ENABLE_HORIZON 1

ENTRYPOINT ["sh", "/var/www/notification/.docker/docker-entrypoint.sh"]

CMD supervisord -n -c /etc/supervisord.conf
