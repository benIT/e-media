# e-media

[![Build Status](https://travis-ci.org/benIT/e-media.svg?branch=dev)](https://travis-ci.org/benIT/e-media) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benIT/e-media/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/benIT/e-media/?branch=dev) 

## Purpose

This project provides a basic layer to manage videos based on [symfony 3](https://symfony.com/).


## Installation 

This project can be easily deployed with [Vagrant](https://www.vagrantup.com/). [A fully provisioned and functional vagrant box is available on vagrant cloud](https://app.vagrantup.com/benit/boxes/e-media).

### Web server

[see webserver setup page](doc/webserver.md)

### Database

[see database setup page](doc/db.md)

### App

#### Dependencies

##### Frontend Dependencies

Frontend dependencies are managed with [bower](https://bower.io/#install-bower).


**[npm](https://nodejs.org/en/download/package-manager/), [grunt](https://gruntjs.com/getting-started), [bower](https://bower.io/#install-bower) must be installed**

For frontend related information, [see this doc page](doc/frontend.md) 

##### Backend Dependencies

Backend dependencies are managed with [composer](https://getcomposer.org/).

#### Building app

Once system dependencies are satisfied, installing the app is quite easy, just clone and run the following command that will build the app!

    composer install
    
The [composer.json uses the `post-install-cmd`](composer.json:52) directive to trigger all necessaries tasks to build fully the app.    

## Tests
    
PHPUnit tests can be run through `composer`:
        
        composer test

### Configuration

#### Parameters

During installation, composer will ask you for parameters, otherwise parameters can be set up in `app/config/parameters.yml`. 

#### Logo

To use your custom logo instead of the default one, put it as follow: `web/assets/dist/image/custom-logo.png`

### Coding

[see detailed documentation](doc/coding.md)