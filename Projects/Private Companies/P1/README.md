
<img src="https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/Private%20Companies/P1/project-description1.jpg1.jpg" />

<img src="https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/Private%20Companies/P1/project-description1.jpg2.jpg" />

<img src="https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/Private%20Companies/P1/project-description1.jpg3.jpg" />

<hr/>

```
composer require ....
```

```
php artisan migrate
```

```
php artisan vendor:publish --tag task-lang
```

4.set your `SMTP` configuration in `.env` file, <b> If you did not set! </b>
```
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

<hr/>

if you need to change migration package </br>
```
php artisan vendor:publish --tag task-migration
```

if you need to change configuration package </br>
```
php artisan vendor:publish --tag task-config
```

if you need <ins>change access logged-in</ins> user to all todo package routes Just create your <ins>custom middleware</ins> and </br> 
add it to the ```middleware key``` in config package file </br>

<hr/>

if you need to run manually schedule you can run </br>
```
php artisan schedule:tasks
```

you can see the scheduling tasks by running </br>
```
php artisan schedule:list
```

