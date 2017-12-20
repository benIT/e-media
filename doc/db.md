# Database

To set DBMS, edit the `Doctrine Configuration` section in [config.yml](../app/config/config.yml):

## mySQL

### Config section in [config.yml](../app/config/config.yml):

    # Doctrine Configuration
    doctrine:
        dbal:
            driver: pdo_mysql
            
### PdoSessionHandler section in [services.yml](../app/config/services.yml):
            

    Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler:
        public:    false
        arguments:
            - 'mysql:host=%database_host%;dbname=%database_name%'
            - { db_username: '%database_user%', db_password: '%database_password%' }

### Server requirement

    sudo apt-get install -y mariadb-server mariadb-common mariadb-client
    sudo mysql -uroot -e "CREATE USER 'emedia'@'localhost' IDENTIFIED BY 'emedia';"
    sudo mysql -uroot -e "GRANT ALL ON *.* TO 'emedia'@'localhost';"
    
                
## PostgreSQL

### Config section in [config.yml](../app/config/config.yml):
            
    # Doctrine Configuration
    doctrine:
        dbal:
            driver: pdo_pgsql            
          
### PdoSessionHandler section in [services.yml](../app/config/services.yml):

    Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler:
        public:    false
        arguments:
            - 'pgsql:host=%database_host%;dbname=%database_name%'
            - { db_username: '%database_user%', db_password: '%database_password%' }   
                   
### Server requirement
                        
    sudo apt-get -y install postgresql phppgadmin php7.0-pgsql
    sudo phpenmod pdo_pgsql
    sudo -u postgres psql -c "CREATE USER emedia WITH PASSWORD 'emedia' CREATEDB;"