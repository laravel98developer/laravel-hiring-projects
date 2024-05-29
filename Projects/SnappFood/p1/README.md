Steps to make the project up and running:

1. Install PHP 8.2
2. Terminal Command: `sudo apt update`
3. Terminal Command: `sudo apt install php-mysql php-mbstring php-xml php-json php-bcmath`
4. Install composer package manager.
5. Install a relational Database (**_MySQL_** preferred).
6. Install **_sqlite3_** for tests.
7. Terminal command: `sudo apt-get install php8.2-sqlite3`
8. Go into database CLI and run this query: `create database snappfood;`
9. Clone this project: ``
10. Create a file in the project's root directory and name it _**.env**_
11. Copy _**.env.example**_ file content into the  _**.env**_
12. Fill the fields below with your database info:

    ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_USERNAME=root
     DB_PASSWORD=

13. Install packages using this command: `composer update`
14. Terminal Command: `php artisan key:generate`
15. Terminal Command: `php artisan serve`
16. Terminal Command: `php artisan migrate`
17. Terminal Command: `php artisan db:seed`
18. Login and get a bearer token:

     POST: <localhost:8000/api/signin>

     Form Body: ['email' => 'a@b.com', 'password' => '123456789']
    * (This API is included in the Postman Collection (Authentication -> Signin))
   

### APIs
* All APIs are included in the Postman Collection.

1. _Order -> Report Delay_

   * POST: <localhost:8000/api/{order_id}/delay-report>
    
   * In order to use call this API, the bearer token must be used.

2. _Order -> Assign Delay Report_

    * GET: <localhost:8000/api/assign-delay-report>

3. _Order -> Assign Delay Report_
    
    * GET: <localhost:8000/api/{{order}}/delay-report>
