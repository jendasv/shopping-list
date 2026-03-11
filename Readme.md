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
Or just
````bash
make init 
````

Project:
- http://localhost:8080/

Adminer:
- http://localhost:8081/