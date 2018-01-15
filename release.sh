#!/bin/bash

#todo make a phing script of that quick and dirty shell script

#script terminate as soon as any command fails
set -e

while [[ $archiveversion == '' ]]
do
    read -p 'archive version?: ' archiveversion
done

#test
php bin/console doctrine:schema:drop --env=test --force
php bin/console doctrine:schema:create --env=test
composer fixtures-test
composer test

#build archive
rm -rf web/e-media-data
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
rm -rf node_modules
cd .. &&  tar -czf e-media-$archiveversion.tgz e-media && du -h e-media-$archiveversion.tgz