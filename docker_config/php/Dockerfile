FROM php:7.4-fpm

RUN   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN   php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN   php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN   chown 1000:1000 /usr/local/bin/composer
RUN   php -r "unlink('composer-setup.php');"

RUN apt-get update \
    && apt-get install -y libzip-dev git zip unzip

RUN  docker-php-ext-install bcmath calendar exif gettext mysqli pcntl pdo_mysql shmop sockets sysvmsg sysvsem sysvshm zip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions uuid gmp soap uopz intl

RUN groupadd dev -g 1000
RUN useradd dev -g dev -d /home/dev -m
