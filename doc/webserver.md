# Webserver

[official ressource for webserver configuration](https://symfony.com/doc/current/setup/web_server_configuration.html)

Large video files are served throught `mod_xsendfile` for Apache and `X-Accel` for Nginx.

Those directives will be used to delegate to webserver large video file serving. [See this controller, for example.](../src/AppBundle/Controller/StreamController.php): 

## Nginx

    sudo apt-get install -y nginx

### Virtual host

Create a vhost in `/etc/nginx/sites-available/emedia`:
    
    server {
        root /vagrant/sites/e-media/web;
    
        location / {
            try_files $uri /app.php$is_args$args;
        }
        location ~ ^/(app_dev|config)\.php(/|$) {
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            fastcgi_param DOCUMENT_ROOT $realpath_root;
        }
        location ~ ^/app\.php(/|$) {
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            fastcgi_param DOCUMENT_ROOT $realpath_root;
            internal;
        }
    
        #used: to stream file directly by the server using 'X-Accel'
        location /stream-files {
            alias /vagrant/sites/e-media-data;
            internal;
        }
    
        location ~ \.php$ {
            return 404;
        }
    
        error_log /var/log/nginx/emedia_error.log;
        access_log /var/log/nginx/emedia_access.log;
    }

    sudo rm -f /etc/nginx/sites-enabled/default 
    sudo ln -s /etc/nginx/sites-available/emedia /etc/nginx/sites-enabled/emedia


## Apache 2

### Modules

Install rewrite module: 
       
       sudo a2enmod rewrite
       
Install xsendfile module.
              
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