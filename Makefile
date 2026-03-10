PHP = docker compose exec php

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

php:
	$(PHP) bash

console:
	$(PHP) php bin/console $(filter-out $@,$(MAKECMDGOALS))

composer:
	$(PHP) composer $(filter-out $@,$(MAKECMDGOALS))

%:
	@: