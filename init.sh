#!/usr/bin/env bash

docker-compose up -d
docker-compose exec time_tracking_php composer install
docker-compose exec time_tracking_php ./bin/console doctrine:database:create
docker-compose exec time_tracking_php ./bin/console doctrine:database:create --env=test
docker-compose exec time_tracking_php ./bin/console doctrine:migrations:migrate
docker-compose exec time_tracking_php ./bin/console doctrine:migrations:migrate --env=test
