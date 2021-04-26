# Time tracking admin

## Init project

Run

```bash
./init.sh
```

Add local hostname `time-tracking.loc` to  `127.0.0.1`

See project here http://time-tracking.loc:10093/

### In details

Install composer dependencies
```bash
docker-compose exec time_tracking_php composer install
```

Create project db structure for 

dev environment 

```bash
docker-compose exec time_tracking_php ./bin/console doctrine:database:create
docker-compose exec time_tracking_php ./bin/console doctrine:migrations:migrate
```

test environment

```bash
docker-compose exec time_tracking_php ./bin/console doctrine:database:create --env=test
docker-compose exec time_tracking_php ./bin/console doctrine:migrations:migrate --env=test
```


## Tests
### Run tests

```bash
docker-compose exec time_tracking_php php vendor/bin/codecept build
docker-compose exec time_tracking_php php vendor/bin/codecept run
```