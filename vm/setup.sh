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
	echo 'Installing Capistrano'
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
	/etc/init.d/apache2 reload
	echo 'Finished Cnfiguring apache2'
    touch /.vm/apache-configured
fi

if [[ ! -f /.vm/mysql-configured ]]; then

	# Kill any mysql processes currently running
	echo 'Shutting down any mysql processes...'
	service mysql stop
 
	# Start mysql without grant tables 
	echo 'Resetting password...'
 
	#Sleep for 5 while the new mysql process loads (if get a connection error you might need to increase this.
	sleep 5
	mysqld_safe --skip-grant-tables &
	sleep 5
 
	#Update user with new password
	mysql mysql -e "UPDATE user SET Password=PASSWORD('1234') WHERE User='root';FLUSH PRIVILEGES;"
 
	echo 'Cleaning up..'
	#Kill the insecure mysql process
	killall -9 mysqld
	service mysql start
    touch /.vm/mysql-configured
fi

#cd /vagrant
chmod -R g+w /vagrant
rm -rf /vagrant/cache
mkdir -p /vagrant/cache
chmod -R 777 /vagrant/cache
