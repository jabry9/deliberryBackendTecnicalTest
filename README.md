# Technical Test Backend

Quick Start
-----------
Docker and docker-compose must be installed on your computer

## Installation

```sh
1. docker-compose build
2. docker-compose up -d
3. docker exec -it deliberry_api_php /bin/bash
4. composer install
5. composer recipes
6. bin/console doctrine:database:create
7. bin/console doctrine:schema:update --force
8. bin/console doctrine:fixtures:load -n
```
## Use
### Default tokens
Ramon_Administrador: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJSYW1vbl9BZG1pbmlzdHJhZG9yIiwidXNlcklkIjoiZjJmZDNkOTItYzUzNC00ZDdjLTg2OWEtYjZhOGRiY2I5NjNmIiwiaWF0IjoxNTE2MjM5MDIyfQ.oMtoCdtv7fMGQ5n4AXKH0IjpMZSUi1DCQ5O91qMPo0o

Juan: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJKdWFuIiwidXNlcklkIjoiMThiNDY1MjYtZGI4MC00NTJhLTgzMzgtNmQwN2ZlZDhmZWJiIiwiaWF0IjoxNTE2MjM5MDIyfQ.qRZ9VtwHzwUEQmCtkuoF6NnTRpRZZYO90YH_9FCyMwA

### Default categories ids

Food: 20f79aa5-fbb5-4d83-b6c7-cfb1afa8ec37

Drinks: ab05d10c-edd7-43ed-a765-5221fa0e7b39


### API Documentation

see documentation [here](documentation/SwaggerUI.html)
