FROM php:5.6.13-apache

# Install extra php modules
RUN apt-get update
RUN apt-get install -y php5-xsl php5-mcrypt libmcrypt-dev libxslt1-dev
RUN docker-php-ext-install mcrypt xsl mysql

# Add source
COPY . /var/www/html/

# Configure mysql credentials / must match the ones in docker-compose.yml
RUN sed -i "s/default_mcir_db_password/mcirpass00112233/" sqlol/includes/database.config.php
RUN sed -i "s/default_mcir_db_password/mcirpass00112233/" cryptomg/includes/db.inc.php

RUN sed -i "s/localhost/mysqldb/" sqlol/includes/database.config.php
RUN sed -i "s/localhost/mysqldb/" cryptomg/includes/db.inc.php

# Misc
RUN chmod 666 xssmh/pxss.html
