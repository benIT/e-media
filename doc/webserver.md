# Webserver

## Nginx

    sudo apt-get install -y nginx
    VHOST=$(cat <<EOF
    server {
        listen 80 default_server;
        listen [::]:80 default_server ipv6only=on;
    
        root /vagrant/sites/e-media/web;
        index app.php index.php index.htm;
    
        location / {
            #dev env
        #try_files $uri /app_dev.php$is_args$args;
        #prod env
        try_files $uri /app.php$is_args$args;
    
        }
    
        location ~ \.php$ {
        include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;   
        }
    }
    EOF
    )
    echo "${VHOST}" > /etc/nginx/sites-available/emedia
    sudo rm -f /etc/nginx/sites-enabled/default 
    sudo ln -s /etc/nginx/sites-available/emedia /etc/nginx/sites-enabled/emedia


## Apache 2

### Modules

Install rewrite module: 
       
       sudo a2enmod rewrite
       
Install xsendfile module. This module will be used to delegate apache large video file serving. [See this controller, for example.](../src/AppBundle/Controller/StreamController.php:19): 
              
      sudo a2enmod xsendfile

Take a look to the configuration in the vhost below.

### Virtual host

Here a basic vhost for running the app in `/etc/apache2/sites-available/video-app.conf` file:

    Listen 10000
    <VirtualHost *:10000>
            #ServerName www.example.com
            ServerAdmin webmaster@localhost
            DocumentRoot /vagrant/shared/videoapp/web
    
            <Directory /vagrant/shared/videoapp>
                    XSendFilePath   /vagrant/shared/videoapp-data/video/
                    Options Indexes FollowSymLinks
                    AllowOverride All
                    Require all granted
            </Directory>
    
            # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
            # error, crit, alert, emerg.
            # It is also possible to configure the loglevel for particular
            # modules, e.g.
            #LogLevel info ssl:warn
    
            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    
    # vim: syntax=apache ts=4 sw=4 sts=4 sr noet
    

Restart apache2:
    
        sudo service apache2 restart 