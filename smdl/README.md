Smindle assignment

## Get started -

1) Clone the git repository

2) In folder smdl/ create a file ``.env`` and copy the contents of the ``.env.example``

3) Run command ``docker-compose up -d`` to run docker containers

4) Run command ``composer install`` for installing dependencies

5) Run command ``./vendor/bin/sail up -d`` for start sail

6) Run command ``./vendor/bin/sail artisan key:generate `` for Project Key

7) Run command ``./vendor/bin/sail artisan migrate`` for database migrations queue

8)Run command ``./vendor/bin/sail artisan queue:work`` for Job queue


## Testing the Payload

1) Make request POST http://localhost:9000/orders with JSON payload

```json
{
    "first_name": "rocky",
    "last_name": "Turing",
    "address": "123 Enigma Ave, Bletchley Park, UK",
    "basket": [
        {
            "name": "Smindle ElePHPant plushie",
            "type": "unit",
            "price": 295.45
        },
        {
            "name": "Premium Support",
            "type": "subscription",
            "price": 99.99
        },
        {
            "name": "Premium Tv 2",
            "type": "subscription",
            "price": 9922.99
        },
        {
            "name": "Premium Insurance 2" ,
            "type": "subscription",
            "price": 929.99
        }
    ]
}
```

2) Check in the DB that new records were created in tables ``orders`` and ``basket_items``

3) Check in file ``/storage/logs/laravel.log`` that the request to third party  API made and results received

