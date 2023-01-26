FROM phpmyadmin/phpmyadmin:5.2.0

ENV PMA_ARBITRARY=1 \
    PMA_HOST='db' \
    PMA_USER='root' \
    PMA_PASSWORD='root'

COPY phpmyadmin-misc.ini /usr/local/etc/php/conf.d/phpmyadmin-misc.ini