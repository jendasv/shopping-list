PHP = docker compose exec php

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build
init:
	docker compose up -d --build
	docker compose exec php composer install
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction

clear:
	docker compose down -v --rmi all

reset:
	docker compose down -v --rmi all
	docker compose up -d --build

php:
	$(PHP) bash

console:
	$(PHP) php bin/console $(filter-out $@,$(MAKECMDGOALS))

composer:
	$(PHP) composer $(filter-out $@,$(MAKECMDGOALS))

%:
	@: