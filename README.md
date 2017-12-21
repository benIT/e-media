# e-media

[![Build Status](https://travis-ci.org/benIT/e-media.svg?branch=dev)](https://travis-ci.org/benIT/e-media) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benIT/e-media/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/benIT/e-media/?branch=dev) 

## Purpose

This project provides a basic layer to manage videos based on [symfony 3](https://symfony.com/).


## Installation 

### Web server

[see webserver setup page](doc/webserver.md)

### Database

[see database setup page](doc/db.md)

### Application

#### Environment variables 

    export DB_NAME=emedia 
    export DB_USER=emedia 
    export DB_PWD=emedia 
    export DB_PORT=null 
    export DB_HOST=localhost

#### Install sources

- Checkout a built version on the [releases page](https://github.com/benIT/e-media/releases). 

Fully built version bundled with all dependencies installed are available under `.tgz` archive.

OR
 
- Build the app from sources. [see building instructions](doc/building.md).

#### Install database

Before installing database, checkout the database parameters in `app/config/parameters.yml`.

##### Create database

    php bin/console doctrine:database:create
       

##### Create schema
    
    php bin/console doctrine:schema:create
    
##### Create sessions table 

    php bin/console doctrine:migrations:migrate

##### Load fixtures 
 
    composer fixtures-dev    

## Configuration

### Parameters

During installation, composer will ask you for parameters, otherwise parameters can be set up in `app/config/parameters.yml`. 

### Logo

To use your custom logo instead of the default one, put it as follow: `web/assets/dist/image/custom-logo.png`

### Building the app

[see detailed documentation](doc/building.md)

### Coding

[see detailed documentation](doc/coding.md)