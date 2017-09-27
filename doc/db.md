### Database

#### Postgres

##### Install a PostgreSQL server

    sudo apt-get -y install postgresql phppgadmin php7.0-pgsql
    sudo phpenmod pdo_pgsql
    sudo service apache2 restart

##### Create a PostgreSQL DB

###### Create app database

    ROLE_NAME="videoapp"
    ROLE_PASSWORD="videoapp"
    sudo -u postgres psql -c "CREATE USER ${ROLE_NAME} WITH PASSWORD '${ROLE_PASSWORD}' CREATEDB;"    
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
    
###### Create test database
    
    ROLE_NAME="testdb"
    ROLE_PASSWORD="testdb"
    sudo -u postgres psql -c "CREATE USER ${ROLE_NAME} WITH PASSWORD '${ROLE_PASSWORD}' CREATEDB;"    
    php bin/console doctrine:database:create --env=test
    php bin/console doctrine:schema:create --env=test

###### Load fixtures
    
    php bin/console doctrine:fixtures:load --no-interaction --env=test

###### Run PHPUnit tests

    vendor/phpunit/phpunit/phpunit