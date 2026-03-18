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
make init
````

### Migration
Run the migration:
````bash
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
````

Project:
- http://localhost:8080/

Adminer:
- http://localhost:8081/

### Enviroment variables
Frontend:
- copy .env.example to .env.development

Development:
- copy .env.example to .env.development

# API list
## Base URL
````URL
http://localhost:8080/api/
````

## List endpoints

### Get list
- Returns a specific list with its items
````URL
GET /lists/:id/items
````

### Create list
- Create a new list, it is also possible to create with items
````URL
POST /lists
````

````json
{
    "name": "My new list with mapper",
    "items": [
        {
            "name": "Milk"
        },
        {
            "name": "Bread"
        },
        {
            "name": "Socks"
        }
    ]
}
````

### Delete list
- Remove a specific list
````URL
DELETE /lists/:id
````

## Items endpoints
### Get item
- Returns a specific item from a specific list
````URL
GET /lists/:id/items/:itemId
````

### Create item
- Add a new item to a specific list
````URL
POST /lists/:id/item
````

````json
{
  "name": "Potatoes",
  "quantity": 5,
  "isCompleted": false
}
````

### Update item
- Change an item in a specific list
````URL
PUT /lists/:id/items/:itemId
````

````json
{
  "name": "Potatoes",
  "quantity": 5,
  "isCompleted": false
}
````

### Remove item
- Remove an item from a specific list
````URL
DELETE /lists/:id
````


