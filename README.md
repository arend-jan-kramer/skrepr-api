``Dev only``

## Require
1. Required software [docker desktop](https://www.docker.com/products/docker-desktop)

## Symfony [Docker]
clone project
```
git clone git@github.com:arend-jan-kramer/skrepr-api.git
```
Start docker from project dir
```
cd skrepr-api
docker-compose up -d
```
Log in to docker container
```
docker exec -it skrepr /bin/bash
```
Create develop configuration file
```
cp .env .env.local
```

Update file permissions
```
cd ..
chown 1000:1000 html -R
cd html
```

Update the DATABASE_URL=
```
DATABASE_URL="mysql://root:secret@db:3306/skrepr?serverVersion=mariadb-10.4.11&charset=utf8mb4"
```

Install packages
```
composer install
```
Create Database
```
php bin/console doctrine:database:create
```
Create tables
```
php bin/console doctrine:migration:migrate
```
Open browser [link](http://localhost:9000)

Endpoints
```
[GET]
localhost:9000/api/memo/{id}
[GET]
localhost:9000/api/memos
[POST]
localhost:9000/api/memo
{
    "name":  "Henk",
    "phoneNumber": "31786820080",
    "description": ""
}
```