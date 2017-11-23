## Dependencies

### Frontend Dependencies

Frontend depencies are managed with [bower](https://bower.io/#install-bower).


**[npm](https://nodejs.org/en/download/package-manager/), [grunt](https://gruntjs.com/getting-started), [bower](https://bower.io/#install-bower) must be installed**

For information related in frontend, [see this doc page](doc/frontend.md) 

### Backend Dependencies

Frontend depencies are managed with [composer](https://getcomposer.org/).

## Building app

Once dependencies are satisfied, installing the app is quite easy, just clone and run the following command that will build the app!

    composer install
    
The [composer.json uses the `post-install-cmd`](composer.json:52) directive to trigger all necessaries tasks to build fully the app.    

## Tests
    
PHPUnit tests can be run through `composer`:
        
        composer test