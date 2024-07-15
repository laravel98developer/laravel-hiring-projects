# Todo list API
### a simple Todo list API

# How To Install

## Environment
* #### Copy .env.example

```bash
cp .env.example .env
```
* #### Check `APP_PORT` in `.env`, the variable is set to have a port outside of docker container
* #### Since this project uses email verification, please add your email configuration in `.env`
* #### in `.env`, `WWW_USER` is set to 1000 by default, change it if you prefer something else 
* #### Check the Database variables in `env`. since project is dockerized, there is a variable named `DB_EXTERNAL_PORT` which is MySQL port outside the docker container

## Docker
* #### Build and run project
```bash
docker compose up -d --build
```

## Dependencies and Docs
* #### Install dependencies using composer
```bash
docker exec -t todo_list_php bash -c "composer install" 
``` 
* #### Generate app key
```bash
docker exec -t todo_list_php bash -c "php artisan key:generate"
```
* #### Migrate Database
```bash
docker exec -t todo_list_php bash -c "php artisan migrate"
```
* #### Seed Database (categories)
```bash
docker exec -t todo_list_php bash -c "php artisan db:seed"
```
* #### Install resources and start Horizon
```bash
docker exec -t todo_list_php bash -c "php artisan horizon:install"
```
```bash
docker exec -t todo_list_php bash -c "php artisan horizon"
```

---

# Generate Docs
```bash
docker exec -t todo_list_php bash -c "php artisan laravel-request-docs:export"
```

# Tests
* #### Run tests using the following command to make sure app works fine
```bash
docker exec -t todo_list_php bash -c "php artisan test"
```

## Documentation
Since Docs are already generated at [Generate Docs](#generate-docs), all you had to do is check the following page: `{app_url}/request-docs`
* #### Note: You need to manually set `Authorization` header in `Set Global Headers` section of Documentation page
