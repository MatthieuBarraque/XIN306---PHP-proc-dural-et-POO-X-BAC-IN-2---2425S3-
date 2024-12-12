sudo cp -r . /var/www/html/
sudo chown -R www-data:www-data /var/www/html/guestbook
sudo chmod -R 755 /var/www/html/guestbook
sudo service apache2 restart
