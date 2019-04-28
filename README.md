# Link shortener API



## Overview
This project use the Symfony PHP Framework.


## Installation details
1. Clone this repository: `git clone https://github.com/vandersonramos/link-shortener-backend.git`
2. Go to the project folder: `cd link-shortener`
3. Run composer: `composer install`
4. In the .env file, change the database values [DB_USER, DB_PASSWORD, DB_HOST,DB_PORT,DB_NAME]
5. Run migrations. 
```
  php bin/console make:migration`
  php bin/console doctrine:migrations:migrate
```



# Using the API

### Shortening a link

Method allowed: POST

Parameter: url  `The url to be shortened`
 

```
curl -X POST http://YOUR_URL_HERE/create \
  -H 'Content-Type: application/json' \
  -H 'cache-control: no-cache' \
  -d '{
	"url": "http://www.google.com"
    }'
```

The return is a json with two fields; [url_shorter, full_url] 

[url_shorter] string representing the url shortened. It is necessary to concatenate with domain.

[full_url] string representing the full url provided.

### Getting the number of views

Method allowed: GET

Parameter: url_key  `The url shortened without domain`
 

```
curl -X GET http://YOUR_URL_HERE/analyze/{url_key} \
  -H 'Content-Type: application/json' \
  -H 'cache-control: no-cache' 
```
The return is a json with one field; [total_views] 

[total_views] null if the provided URL was not found.

[total_views] int representing the total of views.
