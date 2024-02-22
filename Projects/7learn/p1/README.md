![FireShot_Webpage_Capture_165_-__پروژه_استخدامی_برنامه_نویس_بکند_-_Google_Docs__-_docs google com](https://github.com/alisalehi1380/7learn/assets/111766206/f34f9b88-ae0f-49c8-861e-bf1137410056)



![Logo](https://github.com/hamid1ganeh/7learn/blob/main/logo.jpeg)

# 7learn
Firsrt of all you need to clone the project from this repository.
```bash
git clone https://github.com/hamid1ganeh/7learn.git
```
Now please copy env.example file that is located in the root of you'r project and past it in the same path and rename it to .env file.

In order to Integration laravel with elasticsearch you can use  [laravel scout](https://laravel.com/docs/10.x/scout) but in this project I preferred make a costomize class and use elasticsearch functions as OOP and also I used observer in my model for integration between database and elasticseach.

Furthermore in the docker-compose.yml file there are elasticsearch and kibana images but in this project I didn't use them. Because I made my elasticsearch connection directly on a cloud system. If you sign up on [elastic.co](https://www.elastic.co) you can use it free trial for 2 weeks. acording to this [document](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connecting.html) after making you'r first deployment you can set you'r ELASTICSEARCH_ENDPOINT and ELASTICSEARCH_API_KEY in the .env file.
After the indexing of the posts in elasticsearch is finished, a SMS will send to number wich you set as OWNER_MOBILE in .env file and also I use [Candoo](http://my.candoosms.com)  SMS service that you should sign up and set SMS_NUMBER, SMS_USERNAME and SMS_PASSWORD in .env file.


 
After taht in order to download docker images from docker hub please run the following command:
```bash
docker-compose build app
```
and then run:
```bash
docker-compose up -d
```
```bash
docker-compose exec app composer update
```
```bash
docker-compose exec app php artisan key:generate
```

Now you can execute project on [localhost:1370](localhost:1370) 

It's time to data entery in database and elasticsearch by running the following command:
```bash
docker-compose exec app php artisan migrate --seed
```
It takes a long time. Because the last seeder is creating 1 milion record in databae and elasticsearch. but don't wory. you can use the system simultaneously.

Also for any reson if elasticseach datas destroyed don't wory. that's enough just running following command:
```bash
docker-compose exec app php artisan elastic-syncer
```
After running  above command you can observe the result in you'r terminal and finally in the end of this proccess a SMS will send to number wich you set as OWNER_MOBILE in the .env file.
But you should run following command in order to execute SMS job: 
```bash
docker-compose exec app php artisan queue:work
```

Finally I defined a hepler function with a unit test that you can pass it by the following command:
```bash
docker-compose exec app php artisan test
```


## Technologies used

- php 8.2

- [laravel 10](https://laravel.com/docs/10.x)

- [Elasticsearch](https://www.elastic.co/)

- [Candoo SMS Service](http://my.candoosms.com/)

- [Queue & job](https://laravel.com/docs/10.x/queues)
 


## Authors

- [@Hamid1ganeh2st](https://github.com/hamid1ganeh)

