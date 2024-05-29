<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Configuration for the Task Package
    |--------------------------------------------------------------------------
    |
    | This configuration file allows you to customize the behavior of the
    | to-do package in your Laravel application. You can specify the user
    | table, user model, and middleware for the to-do package.
    |
    */
    'user'       => [
        /*
        |--------------------------------------------------------------------------
        | User Table
        |--------------------------------------------------------------------------
        |
        | Here you can specify the table name for the user model in your application.
        | Update the 'table' key to match the desired table name for users.
        |
        */
        'table' => 'users',
        
        /*
        |--------------------------------------------------------------------------
        | User Model
        |--------------------------------------------------------------------------
        |
        | Update the 'model' key to specify the fully qualified class name of your
        | user model. This allows the to-do package to associate tasks with users.
        |
        */
        'model' => 'App\Models\User',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware key allows you to customize the middleware used by the
    | to-do package. You can update the 'middleware' key to specify the
    | desired middleware class or group for task-related routes.
    |
    */
    'middleware' => 'AliSalehi\Task\Http\Middleware\TaskMiddleware',
];