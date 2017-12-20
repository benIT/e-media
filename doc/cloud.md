#Cloud

# Environement variables 

    export DB_NAME=emedia 
    export DB_USER=emedia 
    export DB_PWD=emedia 
    export DB_PORT=null 
    export DB_HOST=localhost

## Heroku

    heroku pg:reset --confirm immense-island-52888
    git push heroku master
    heroku run php bin/console doctrine:migrations:migrate
