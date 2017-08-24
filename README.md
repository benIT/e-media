# video-app

A symfony 3 POC for a video app.


## Installation 

### App

    composer install

### Database

#### Postgres

##### Install a Postgre server

    sudo apt-get -y install postgresql-9.4 postgresql-client-9.4 php5-pgsql phppgadmin
    sudo sed -i "s/^Require local/#Require local comment to access pgadmin out from the box/"  /etc/apache2/conf-available/phppgadmin.conf
    sudo service apache2 restart

##### Create a Postgre DB

    ROLE_NAME="videoapp"
    ROLE_PASSWORD="videoapp"
    DATABASE_NAME="videoapp"
    
    sudo -u postgres psql -c "CREATE ROLE ${ROLE_NAME} LOGIN UNENCRYPTED PASSWORD '${ROLE_PASSWORD}' NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;"
    sudo -u postgres psql -c "CREATE DATABASE ${DATABASE_NAME}"
    sudo service postgresql restart
