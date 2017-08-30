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

    composer install

## Tests
    
PHPUnit tests can be run through `composer`:
        
        composer test