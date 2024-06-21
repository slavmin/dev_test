FROM php:8.2-fpm

RUN groupadd -g 1000 developer
RUN useradd -u 1000 -ms /bin/bash -g developer developer

RUN mkdir -p /var/www/html

RUN chown developer:developer /var/www/html

WORKDIR /var/www/html

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer