FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Set timezone
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Warsaw /etc/localtime \
    && "date"

# Install PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libyaml-dev \
        vim \
    && docker-php-ext-install -j$(nproc) iconv bcmath \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y zlib1g-dev libicu-dev g++ libzip-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl zip sockets && \
    apt-get purge -y g++

RUN apt-get install -y libxslt-dev
RUN docker-php-ext-install xsl soap mysqli

# Install xdebug - no stable version for 7.3 yet
RUN pecl install xdebug-2.7.0beta1 \
    && docker-php-ext-enable xdebug \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.profiler_enable_trigger=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Redis extension
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/docker-php-ext-redis.ini

# Install MongoDB extension
RUN pecl install mongodb \
    && rm -rf /tmp/pear \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-php-ext-mongodb.ini

# Install YAML extension
RUN pecl install yaml \
    && rm -rf /tmp/pear \
    && echo "extension=yaml.so" >> /usr/local/etc/php/conf.d/docker-php-ext-yaml.ini

# Set ID
RUN usermod -u 1000 www-data

# Add aliases for xdebug control
RUN echo 'alias xoff="mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off && kill -USR2 1"' >> ~/.bashrc
RUN echo 'alias xon="mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && kill -USR2 1"' >> ~/.bashrc

# Change memory limit
RUN echo 'memory_limit = 2G ' >> /usr/local/etc/php/php.ini

# Add aliases for www-data user
RUN touch /var/www/.bashrc && chown www-data /var/www/.bashrc
USER www-data
RUN echo 'alias ll="ls -l"' >> ~/.bashrc
