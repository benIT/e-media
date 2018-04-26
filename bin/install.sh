#!/bin/bash
#usage :
#cd e-media
#./bin/install.sh


#script terminate as soon as any command fails
set -e

while getopts ":f" opt; do
  case $opt in
    f)
      echo "database will be dropped" >&2
      php bin/console doctrine:database:drop --force
      ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
      exit 1
      ;;
  esac
done

php bin/console doctrine:database:create
php bin/console doctrine:schema:create
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:fixtures:load --no-interaction --env=dev
php bin/console app:lti-register-consumer --consumerKey=moodle --consumerName=moodle --consumerSecret=moodle -n
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod