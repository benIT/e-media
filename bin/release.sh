#!/bin/bash

#todo make a phing script of that quick and dirty shell script

#script terminate as soon as any command fails
set -e

WORKING_DIR='/tmp'
VERSION=$1
DELIVERY_PATH='/vagrant/shared/delivery/'
mkdir -p $DELIVERY_PATH
while [[ $VERSION == '' ]]
do
    read -p 'archive version?: ' VERSION
done
cd $WORKING_DIR
rm -rf e-media*
git clone -b $VERSION git@github.com:benIT/e-media.git
cd $WORKING_DIR/e-media

#test
composer install -n
yarn install
php bin/console doctrine:schema:drop --env=test --force
php bin/console doctrine:schema:create --env=test
composer fixtures-test
composer test
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod

#create build file
cat >../build.json <<EOF
{
  "version": "$VERSION"
}
EOF

#build archive
rm -rf web/e-media-data
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
rm -rf node_modules
rm -rf .git
cd .. &&  tar -czf e-media-$VERSION.tgz e-media && du -h e-media-$VERSION.tgz
mv e-media-$VERSION.tgz $DELIVERY_PATH
echo "delivery available at $DELIVERY_PATH/e-media-$VERSION.tgz"