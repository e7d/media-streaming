#!/bin/sh

echo "Update APT definitions"
cd /tmp
wget https://www.dotdeb.org/dotdeb.gpg
apt-key add dotdeb.gpg
echo "deb http://packages.dotdeb.org jessie all" >/etc/apt/sources.list.d/dotdeb.list
echo "deb-src http://packages.dotdeb.org jessie all" >>/etc/apt/sources.list.d/dotdeb.list
apt-get update

echo "Install PHP7"
apt-get -y install php7.0 php7.0-fpm php7.0-cli php7.0-curl php7.0-json php7.0-pgsql

echo "Install Xdebug"
cd /usr/src
git clone git://github.com/xdebug/xdebug.git
cd xdebug
phpize
./configure --enable-xdebug
make
make install
echo 'zend_extension="xdebug.so"' >>/etc/php/7.0/cli/php.ini
echo 'zend_extension="xdebug.so"' >>/etc/php/7.0/fpm/php.ini

echo "Disable OP Cache"
#sed -i '/;opcache.enable=1/c\opcache.enable=0' /etc/php/7.0/fpm/php.ini

echo "Restart PHP FPM"
service php7.0-fpm restart

# echo "Install PHP5 FPM"
# apt-get -y install php5 php5-fpm php5-cli php5-curl php5-pgsql
#
# echo "Disable OP Cache"
# sed -i '/;opcache.enable=0/c\opcache.enable=0' /etc/php5/fpm/php.ini
# service php5-fpm force-reload

exit 0
