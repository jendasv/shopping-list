# Shopping list

## Installation

````bash
git clone ...
cd schopping-list
````

### Docker

````bash
docker compose up -d --build
docker compose exec php composer install
````

## Migration
````bash
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
````

### Docker & Migrations through Makefile
It is prepared Makefile for shortening the process:
````bash
make init
````

Project:
- http://localhost:8080/

Adminer:
- http://localhost:8081/