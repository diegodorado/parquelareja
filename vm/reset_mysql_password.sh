#!/bin/bash

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
mysql mysql -e "UPDATE user SET Password=PASSWORD('$2') WHERE User='$1';FLUSH PRIVILEGES;"
 
echo 'Cleaning up..'
 
#Kill the insecure mysql process
killall -9 mysqld
service mysql start