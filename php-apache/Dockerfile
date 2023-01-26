FROM php:8.2.1-apache

# composerをインストール
COPY --from=composer /usr/bin/composer /usr/bin/composer

# php.iniファイルをコピー
COPY php.ini /usr/local/etc/php/

# ドキュメントルートを変更
COPY 000-default.conf /etc/apache2/sites-available/

# AllowOverrideをNone -> All へ変更。
COPY apache2.conf /etc/apache2/apache2.conf

ENV TZ='Asia/Tokyo'

# Nodejsをインストール
RUN curl  -sS https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

# .htaccessを有効化
RUN a2enmod rewrite

RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim \
libpng-dev \
libpq-dev \
&& docker-php-ext-install pdo_mysql mysqli

EXPOSE 5173