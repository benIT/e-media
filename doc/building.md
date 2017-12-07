## Dependencies

### Frontend Dependencies

Frontend depencies are managed with [bower](https://bower.io/#install-bower).


**[npm](https://nodejs.org/en/download/package-manager/), [grunt](https://gruntjs.com/getting-started), [bower](https://bower.io/#install-bower) must be installed**

For information related in frontend, [see this doc page](doc/frontend.md) 

### Backend Dependencies

Frontend depencies are managed with [composer](https://getcomposer.org/).

## Building app

Once dependencies are satisfied, just clone and run the following commands that will build the app:

      composer install
      composer install-assets
      composer dump-translation
      composer build-assets
      php bin/console doctrine:database:create
      php bin/console doctrine:schema:create
      php bin/console doctrine:migrations:migrate
      composer fixtures-dev

## Tests
    
PHPUnit tests can be run through `composer`:
        
        composer test