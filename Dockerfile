FROM richarvey/nginx-php-fpm:3.1.4

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV DB_CONNECTION pgsql
ENV DB_HOST dpg-ckkdva66fcos73e7lg5g-a
ENV DB_PORT 5432
ENV DB_DATABASE socmed
ENV DB_USERNAME socmed_user
ENV DB_PASSWORD 5SGoVd3WiaVp7J9aBX6ksoqkNsPFfy4j

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]