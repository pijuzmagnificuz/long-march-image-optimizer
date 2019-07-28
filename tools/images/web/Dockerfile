FROM richarvey/nginx-php-fpm:latest
ARG PHP_POST_MAX_SIZE=4M
ARG PHP_MEM_LIMIT=32M
ARG HIDE_NGINX_HEADERS=0
ARG ERRORS=1
ARG NGINX_HOST=project_name.web
# ARG MYSQL_HOST=project_name.db
ARG PHP_VERSION=latest
ARG PHP_MODULES="intl gd xdebug mysqli opcache zip dom soap"
# ARG MYSQL_DATABASE=project_name
# ARG MYSQL_USER=project_name
# ARG MYSQL_PASSWORD=project_name
ARG PROGRAMS_TO_INSTALL='curl wget unzip nano optipng gifsicle jpegoptim composer imagemagick'

COPY ./custom-start.sh /custom-start.sh


RUN \
    echo 'Installing extra software. Please wait' && \
    (apk update ||true) && \
    apk add ${PROGRAMS_TO_INSTALL};

RUN \
    docker-php-ext-enable ${PHP_MODULES};

RUN \
    chown -R nginx:nginx /var/www/html;

STOPSIGNAL SIGTERM

CMD ["/custom-start.sh"];
