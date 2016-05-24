#!/bin/bash
apt-get install apache2 libapache2-mod-php5 php5-xsl php5-mcrypt mysql-server php5-mysqlnd
echo -n "Please enter your database username: ";read username
echo -n "Please enter your database password: ";read password
mv sqlol/includes/database.config.php sqlol/includes/database.config.php.orig
mv cryptomg/includes/db.inc.php cryptomg/includes/db.inc.php.orig
sed "s/root/$username/" sqlol/includes/database.config.php.orig | sed "s/default_mcir_db_password/$password/" > sqlol/includes/database.config.php
sed "s/root/$username/" cryptomg/includes/db.inc.php.orig | sed "s/default_mcir_db_password/$password/" > cryptomg/includes/db.inc.php
chmod 666 xssmh/pxss.html
echo "Initializing SQLol database..."
php sqlol/resetbutton.php
echo "MCIR should be set up now. Enjoy!"
