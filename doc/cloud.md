#Cloud

## Heroku

    heroku pg:reset --confirm e-media
    git push heroku master
    heroku run php bin/console doctrine:migrations:migrate
