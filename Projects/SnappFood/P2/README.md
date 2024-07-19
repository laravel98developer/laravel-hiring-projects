<p align="center"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTU0uR9yfdnvmdumz9MnO4pMWexVhc6DfBv2Vg2K2im-w&s" width="400"></p>

## About This project

1. there are three route prefix including admin,agents,customers
2. admin can create and show some entity(agents,trips,vendors), also update trips status
3. agents can see delay reports analytics also request for assigning delay reports
4. customers can create delay reports for an order also can see orders and create a order
5. also when you run `php artisan db:seed`, it maks some entity for your test:
   1. order without delay `01HXKK57NZAZ6G37D10QYYE41S`
   2. order without trip `01HXKKWRGMTT1YCBD22RN54D8H`
   3. order with delivered trip `01HXKKWXSK03E43RHSDTDCW33C`
   4. order with assigned trip `01HXKKX9XKFXJ0SM8EVR5Q3PM4`,
   5. agent `01HXKKXN075Z3339HDEN3Z3HP2`,
   6. agent `01HXKKXW56JW37DDENTBFT554G`,
6. there are some tests for checking different scenarios that it is run by `php artisan test` 
7. you can see routs list by `php artisan rout:list` 

## Requirements

1. PHP >= 8.2
2. POSTGRES >= 14.11
3. Composer >= 2.7.1

## Deploy project

1. git clone git@github.com:mnbp1371/snappfood-task.git
2. cd snappfood-task
3. composer install
4. cp .env.example .env
5. vi .env
6. php artisan migrate:fresh
7. php artisan db:seed
8. php artisan key:generate
9. echo '127.0.0.1 snappfood-task.local' | sudo tee -a /etc/hosts
10. sudo php artisan serve --host=snappfood-task.local --port=80
11. Open project on http://snappfood-task.local

## Deploy project via docker

1. git clone git@github.com:mnbp1371/snappfood-task.git
2. cd snappfood-task
3. docker compose up
4. docker exec -it snappfood.app /bin/bash
5. composer install
6. cp .env.example .env
7. php artisan migrate:fresh
8. php artisan db:seed
9. php artisan key:generate
11. Open project on http://127.0.0.1:8000





