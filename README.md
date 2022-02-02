# rest-api-example

Rest Api Example build on Laravel. <br />
Laravel version: 8.81.0 <br />
Php version: 8.1.2 <br />
MySql version: 8.0.27 <br />

## Installation

Use the git and composer to install

```bash
git clone https://github.com/barisakdemir/rest-api-example
cd rest-api-example/
cp .env.example .env
```

Edit .env file for MySql information then

```bash
composer install
php artisan key:generate
php artisan config:cache
php artisan migrate:refresh --seed
php artisan serve
```

Crontab jobs

```
30 9 * * *  wget http://127.0.0.1:8000/api/company/packages/receive-payments
*/5 * * * * php ~/folder/to/project/rest-api-example/artisan queue:work --stop-when-empty
```


## Tests on postman import json

[Postman Json File](https://github.com/barisakdemir/rest-api-example/blob/main/rest-api-example.postman_collection.json)

