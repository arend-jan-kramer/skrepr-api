FROM php:8.1-apache
COPY .. /var/www/html
COPY /sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y vim unzip git
RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony/bin/symfony /usr/local/bin

RUN git config --global user.email "you@example.com" \
    &&  git config --global user.name "Your Name"

WORKDIR /var/www/html