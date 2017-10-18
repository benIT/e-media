# Database

To set database, edit the following section in [config.yml](../app/config/config.yml):

    # Doctrine Configuration
    doctrine:
        dbal:
            driver: pdo_mysql
## mariaDB

    sudo apt-get install -y mariadb-server mariadb-common mariadb-client
    sudo mysql -uroot -e "CREATE USER 'emedia'@'localhost' IDENTIFIED BY 'emedia';"
    sudo mysql -uroot -e "GRANT ALL ON *.* TO 'emedia'@'localhost';"

## Postgres

    sudo apt-get -y install postgresql phppgadmin php7.0-pgsql
    sudo phpenmod pdo_pgsql
    sudo service apache2 restart