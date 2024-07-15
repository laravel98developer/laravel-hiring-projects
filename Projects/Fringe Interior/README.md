a simple CRUD API-based app using Laravel, Mongodb, Redis and Repository Pattern.


### Installation
- ### Makefile
    
    you can run `make` command in root directory of project to set up and build docker compose, generate app key, run tests and migrations and see routes list.

- ### Manual

    Run the following commands:
    
    - `cp .env.example .env`
    - `docker compose up --build -d`
    - `docker exec -t barena_php -c bash "php artisan key:generate"` (generate app key)
    - `docker exec -t barena_php -c bash "php artisan test"` (run tests)
    - `docker exec -t barena_php -c bash "php artisan migrate"` (to ensure php is connected to mongo)
    - `docker exec -t barena_php -c bash "php artisan route:list"` (see routes of project)
