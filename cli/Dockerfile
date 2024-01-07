FROM phusion/baseimage:jammy-1.0.1

RUN  install_clean php-mysql php-curl php-json php-xml php-zip unzip

ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

ENV APP_ENV prod
WORKDIR /var/www/html

COPY ./docker_configs/on_container_startup.sh /etc/my_init.d/on_container_startup.sh
RUN chmod +x /etc/my_init.d/on_container_startup.sh

COPY --chown=www-data:www-data composer.* symfony.lock .env .env.* ./

RUN composer install --no-dev --no-cache --no-scripts && composer dump-env prod

COPY --chown=www-data:www-data . .

EXPOSE 80