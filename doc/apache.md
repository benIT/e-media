# Apache 2

## Modules

Install rewrite module: 
       
       sudo a2enmod rewrite
       
Install xsendfile module. This module will be used to delegate apache large video file serving. [See this controller, for example.](../src/AppBundle/Controller/StreamController.php:19): 
              
      sudo a2enmod xsendfile

Take a look to the configuration in the vhost below.

## Virtual host

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