#!/usr/bin/env bash

######### Full setup for foxcet websites under Ubuntu 20 (18/16 also ok)#########

#----- install lamp -----#
sudo apt update
sudo apt install apache2
sudo systemctl start apache2
sudo systemctl enable apache2
sudo ufw allow http #optional
sudo a2enmod proxy_http
sudo a2enmod rewrite
sudo systemctl reload apache2

sudo apt install mariadb-server mariadb-client
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo mysql_secure_installation

sudo apt install php libapache2-mod-php php-mysql php-common

# install cerbot
sudo apt install certbot python2-certbot-apache

# install apc
sudo apt-get install php-apcu

#----- Setup xparser ----#
# install nodejs & npm
sudo apt install nodejs
sudo apt install npm

# install tor
sudo apt install tor
sudo systemctl enable tor

# install xparser
cd /var/www/html/
sudo git clone https://d74ba8abb0f19ce065c6128e8069c33c68b3fc36@github.com/elevenfox/xparser.git
cd xparser
sudo npm install
sudo cp xparser.service /etc/systemd/system/
sudo systemctl start xparser
sudo systemctl enable xparser


# install codebase
sudo git clone https://d74ba8abb0f19ce065c6128e8069c33c68b3fc36@github.com/elevenfox/foxcet.git
sudo mv foxcet pabcd
sudo echo "current_settings_file = settings.pabcd.ini" > pabcd/conf/settings.local.ini

sudo git clone https://d74ba8abb0f19ce065c6128e8069c33c68b3fc36@github.com/elevenfox/foxcet.git
sudo mv foxcet jp
sudo echo "current_settings_file = settings.jp.ini" > jp/conf/settings.local.ini

sudo git clone https://d74ba8abb0f19ce065c6128e8069c33c68b3fc36@github.com/elevenfox/foxcet.git
sudo mv foxcet yfx
sudo echo "current_settings_file = settings.yfx.ini" > yfx/conf/settings.local.ini

# config apache
sudo cp pabcd/z.deploy/apache.conf/* /etc/apache2/sites-enabled/
sudo certbot --apache


# config cron
echo "0 0,12 * * * root python -c 'import random; import time; time.sleep(random.random() * 3600)' && certbot renew -q" | sudo tee -a /etc/crontab > /dev/null