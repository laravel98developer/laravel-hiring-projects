## Scenario 
In the middle of a football match, a charge code is published, the first 1000 users who send this code by their phone number win, and their wallets balance is charged 1,000,000$

## Solution
I store the number of winners in a cache key. when a user sends a code, I check the cache and if the number of winning users is equal to 1000 an error message is returned, else if the user wins the code his data is stored in the cache including the code and phone number, also the number of winners in the cache is updated. The reason that the user data is stored in the cache is to prevent duplicating requests. before checking the code a middleware checks if this code and the phone number are already stored in the cache. if so an abortion occurs. 

Afterward, the data is published to a channel Redis and a successful message is returned. on behind the subscribe command gets the data and dispatches two jobs for charging the wallet balance and adding the transaction of the user. and these two jobs are using queue to be run.

Note:
all the cache keys have 48 hours of expiration time.

## Setup The Project
Use the following command to run the docker:

```php
docker compose up -d --build
```

List of images:

`php` `mysql` `phpmyadmin` `redis`

Then run the following command for migration:

```php
php artisan migrate --seed
```

Then run the following command to listen to the subscribe channel of redis:

```php
php artisan redis:subscribe
```

And finally, run the following command to listen to the queue:

```php
php artisan queue:work
```

You can access the database by the following address:

```php
http://localhost:9090
```

The base address for calling the APIs:

```php
http://localhost:8000
```

Download the Postman API:

[Postman API Collection](https://github.com/farshadth/AbrArvan-Challenge/blob/master/AbrArvan.postman_collection.json)

