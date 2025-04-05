FROM php:8.1-apache

# 必要な拡張機能をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# wait-for-it.sh をコピー
COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Apacheの設定
RUN a2enmod rewrite
COPY . /var/www/html/
EXPOSE 80

# MySQLが起動するまで待機してからApacheを起動
CMD ["/usr/local/bin/wait-for-it.sh", "mysql:3306", "--", "apache2-foreground"]
