### Database

#### Postgres

##### Install a PostgreSQL server

    sudo apt-get -y install postgresql phppgadmin php7.0-pgsql
    sudo phpenmod pdo_pgsql
    sudo service apache2 restart

##### Create a PostgreSQL DB

    ROLE_NAME="videoapp"
    ROLE_PASSWORD="videoapp"
    DATABASE_NAME="videoapp"
    sudo -u postgres psql -c "CREATE ROLE ${ROLE_NAME} LOGIN UNENCRYPTED PASSWORD '${ROLE_PASSWORD}' NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;"
    sudo -u postgres psql -c "CREATE DATABASE ${DATABASE_NAME}"
    sudo service postgresql restart

    php bin/console doctrine:schema:create
