FROM php:8.0.13-apache

# extension
RUN apt-get update \
    && docker-php-ext-install pdo_mysql mysqli

# composer
RUN curl -S https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# node
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
    && export NVM_DIR="$HOME/.nvm" \
    && . $NVM_DIR/nvm.sh \
    && nvm install v14.16.0 \
    && nvm use v14.16.0 \
    && nvm alias default v14.16.0 \
    && npm install -g npm