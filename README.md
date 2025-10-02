## Prerequisite

Before running the application, you need to install needed package to install needed or run code base.

For Ubuntu systems
[npm](https://nodejs.org/en/download)
[composer](https://getcomposer.org/download/)
[php 8.3](https://www.php.net/downloads.php?usage=web&os=linux&osvariant=linux-ubuntu&version=8.3&multiversion=Y)

or 

Installing package manager, but for the composer package, you need to install it after doing this command. 
* Require `sudo` access to install
```
sudo apt install -y npm php8.3 php8.3-zip php8.3-zip php8.3-sqlite3 php8.3-pgsql php8.3-mysql php8.3-mbstring
```

## Installing need dependencies for the project
### Installing FrontEnd dependencies for ReactJs/Javascript
on Linux
```
npm install
```
### Installing BackEnd dependencies for Laravel/PHP
on Linux
```
composer install
```

## Running a configuration script to quicker setting up .env file
To run on Linux
```
bash LaravelEnvSetUp.sh
```

## Starting up a local server environment
```
php artions serve --port 8484
```


Installing on ubuntu for external access, to the panel.
```
sudo apt install -y apache2
```


Going to create/open the apache config file for roadroad.
```
sudo nano /etc/apache2/sites-available/roboroad.conf
```

Copy this configuration to the file
``` Apache
<VirtualHost *:80>
        ServerName _
#        return 301 https://kaasilius.xyz;
        ProxyPass "/"  "http://127.0.0.1:8484/"
</VirtualHost>

#<VirtualHost *:443>
#        ServerName _
#        SSLEngine on
#        SSLCertificateFile ""
#        SSLCertificateKeyFile ""
#        ProxyPass "/"  "http://127.0.0.1:8484/"
#</VirtualHost>
```

Now press `Ctrl + s` to save config file then `Ctrl + x` to close nano.

Now we going to enable the file
```
sudo a2ensite road.conf 
sudo a2dissite 000-default.conf 
sudo a2ensite road.conf
sudo systemctl restart apache2
```