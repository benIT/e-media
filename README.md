# video-app

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benIT/sf3-video-app/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/benIT/sf3-video-app/?branch=dev) [![Build Status](https://scrutinizer-ci.com/g/benIT/sf3-video-app/badges/build.png?b=dev)](https://scrutinizer-ci.com/g/benIT/sf3-video-app/build-status/dev)

## Purpose

This project provides a basic layer to manage videos based on [symfony 3](https://symfony.com/).


## Installation 

### Apache2 web server

For setting Apache2 as a webserver to run, the app see [apache2 setup page](doc/apache.md)

### PostgreSQL Database

App is configured for PostgreSQL see [this doc for PostgreSQL setup](doc/db.md).

### App

#### Dependencies

##### Frontend Dependencies

Frontend depencies are managed with [bower](https://bower.io/#install-bower).

[Videojs](http://videojs.com/getting-started/) is tracked by bower and is built with [grunt](https://gruntjs.com/getting-started) that relies on [npm](https://nodejs.org/en/download/package-manager/).

**So: [npm](https://nodejs.org/en/download/package-manager/), [grunt](https://gruntjs.com/getting-started), [bower](https://bower.io/#install-bower) must be installed** 

##### Backend Dependencies
Frontend depencies are managed with [composer](https://getcomposer.org/).

#### Building app

Once dependencies are satisfied, installing the app is quite easy, just clone and run the following command that will build the app!

    composer install
    
The [composer.json uses the `post-install-cmd`](composer.json:52) directive to trigger all necessaries tasks to build fully the app.    

## Tests
    
PHPUnit tests can be run through `composer`:
        
        composer test