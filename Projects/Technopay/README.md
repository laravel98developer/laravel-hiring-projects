
![challenge-img](https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/Technopay/challenge-img.png)

#  🔥 Order Filtering Code Challenge

``note : create a database with name test_db to run tests``

|  #  |                     #filers                     |                                                       #e.g                                                       |
|:---:|:-----------------------------------------------:|:----------------------------------------------------------------------------------------------------------------:|
|  1  | status [null=false ,0=false,any character=true] |                                  http://127.0.0.1:8000/api/orders/filter?status                                  |
|  2  |                  national_code                  |                         http://127.0.0.1:8000/api/orders/filter?national_code=0000000000                         |
|  3  |                     mobile                      |                            http://127.0.0.1:8000/api/orders/filter?mobile=09121111111                            |
|  4  |                       min                       |                                 http://127.0.0.1:8000/api/orders/filter?min=2000                                 |
|  5  |                       max                       |                                http://127.0.0.1:8000/api/orders/filter?max=500000                                |
|  6  |                  main and max                   |                           http://127.0.0.1:8000/api/orders/filter?min=2000&max=500000                            |
|  7  |                   combination                   | http://127.0.0.1:8000/api/orders/filter?national_code=0000000000&mobile=09121111111&min=2000&max=500000&status=1 |

### result prev

```json
{
    "data": [
        {
            "mobile_number": "09121111111",
            "national_code": "0000000000",
            "amount": 500000,
            "status": "success"
        }
    ]
}
```
