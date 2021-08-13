FROM php:7.4-apache

# Change timezone
ENV TIMEZONE Europe/Paris

RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime
RUN echo "${TIMEZONE}" > /etc/timezone

# Apt-get install
RUN apt-get update \
    && apt-get install -y iproute2 git vim ssl-cert unzip curl wget iputils-ping htop dnsutils \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Clean apt-get
RUN rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# Composer install
RUN curl -sSL https://getcomposer.org/download/1.10.16/composer.phar -o /usr/bin/composer && chmod 775 /usr/bin/composer

# Expose web ports
EXPOSE 80 443

# Enable "perhaps"
RUN a2enmod rewrite
RUN service apache2 restart