#!/bin/bash

#rm -rf /.vm/

if [[ ! -d  /.vm ]]; then
    mkdir /.vm
    echo "Created directory /.vm"
fi

if [[ -f /root/.profile ]]; then
    rm /root/.profile
    echo "Removed rm /root/.profile that generates no tty warnings"
fi


if [[ ! -f /.vm/php5-cli-installed ]]; then
	echo 'Installing php5-cli'
	apt-get install -y php5-cli > /dev/null
  touch /.vm/php5-cli-installed
fi



if [[ ! -f /.vm/capistrano-installed ]]; then
	echo 'Installing Capistrano... adn git'
	apt-get install -y git-core
	gem install capifony --no-ri --no-rdoc
  touch /.vm/capistrano-installed
fi


if [[ ! -f /.vm/configuration-checked ]]; then
	echo 'Checking symfony configuration'
	wget -q "http://trac.symfony-project.org/browser/branches/1.4/data/bin/check_configuration.php?format=raw" -O "/tmp/check_configuration.php"
	php /tmp/check_configuration.php
	rm /tmp/check_configuration.php
  touch /.vm/configuration-checked
fi

if [[ ! -f /.vm/apache-configured ]]; then
	echo 'Configuring apache2'
	cp /vagrant/vm/apache/envvars /etc/apache2/
	a2enmod rewrite
	cp /vagrant/vm/apache/default* /etc/apache2/sites-available/
	/etc/init.d/apache2 restart #reload inst enough since we changed envvars
	echo 'Finished Configuring apache2'
  touch /.vm/apache-configured
fi

if [[ ! -f /.vm/site-configured ]]; then
	chmod -R g+w /vagrant
	mkdir -p /vagrant/cache
	chmod -R g+w /vagrant/cache
	cd /vagrant
	cap database:restore #restore db first...need a backup!
	php symfony doctrine:migrate
	php symfony cc
	php symfony project:permissions
	echo 'Finished Configuring site'
  touch /.vm/site-configured
fi


