### AWS ###

These are not automatically open to the internal networks.

Aurora PORT FW
REDIS PORT FW
	telnet host [port]

####
Commands
####

#### Change SSHD  ###
    1  vi /etc/ssh/sshd_config

### INSTALL PACKAGES ###
    2  apt-get update
    3  apt-get upgrade;
    4  apt-get install nginx
   20  add-apt-repository ppa:ondrej/php
   21  add-apt-repository ppa:ondrej/nginx-mainline
   22  apt-get install php7.4-pgsql
   23  apt-get install php7.4-curl
   24  apt-get install php7.4-intl
   50  apt-get install git
  125  apt-get install libfcgi0ldbl
  137  apt-get install php7.4-xml
    3  sudo apt-get install php-fpm
   35  apt install php-robmorgan-phinx


### INSTALL COMPOSER ###
    5  mv composer.phar /usr/local/bin/composer
    6  sudo mv composer.phar /usr/local/bin/composer
    7  chmod +x /usr/local/bin/composer

#### Attach Extra Drive ###
   26  file -s /dev/xvdb
   27  mkfs -t xfs /dev/xvdb
   28  file -s /dev/xvdb
   32  mkdir /app_disk
   33  mount /dev/xvdf /app_disk/
   34  mount /dev/xvdb /app_disk/
   35  cp /etc/fstab /etc/fstab.orig
   36  blkid
   37  vi /etc/fstab
   38  umount /app_disk
   39  vi /etc/fstab
   40  mount -a
   51  mkdir app
   52  mkdir app/vpp
   48  chown www-data:www-data /app_disk/
   152  apt-get install redis-tools
   154  apt install -y php-pear
   156  apt install php7.4-dev
   155  printf "no\n" | pecl install redis
   235  apt-get install redis-tools
   208  apt-get install postgresql-client


### CONFIGURE NGINX ###
   60  touch demo.visionplanpro.com



## TESTING TOOLS ##
  135  CI_ENV=testing SCRIPT_NAME=/index.php   SCRIPT_FILENAME=/app_disk/app/vpp/index.php  REQUEST_METHOD=GET   cgi-fcgi -bind -connect /var/run/php/php7.4-fpm.sock




 203  echo "extension=redis.so" > /etc/php/7.4/mods-available/redis.ini
  204  ln -sf /etc/php/7.4/mods-available/redis.ini /etc/php/7.4/fpm/conf.d/20-redis.ini
  205  ln -sf /etc/php/7.4/mods-available/redis.ini /etc/php/7.4/cli/conf.d/20-redis.ini
  223  vi /app_disk/app/vpp/.env.testing

  ## SETTING UP PROJECT DEPLOYMENT ##

    CD /app_disk/app/vpp/retail/
    composer install
    cd /app_disk/app/vpp/application/libraries/codeigniter-predis
