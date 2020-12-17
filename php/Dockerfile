FROM php:7.4-apache

#update and mysql 
RUN apt-get update && apt-get install -y libonig-dev && \
  docker-php-ext-install pdo_mysql mysqli mbstring && \
  a2enmod rewrite

# appacheの設定ファイル 設定変える場合は/php/conf/XXX.conf ファイルを作ってそこに書き込み後、下のコメントアウトを外す
# COPY ./conf/*.conf /etc/apache2/apache2.conf