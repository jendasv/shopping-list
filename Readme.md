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

### Docker through Makefile

It is prepared Makefile for shortening the process:
````bash
make build
make composer install
````

## Migration
````bash
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
````

Project:
- http://localhost:8080/

Adminer:
- http://localhost:8081/