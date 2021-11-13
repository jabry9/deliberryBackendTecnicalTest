docker-compose build
docker-compose up -d
docker exec -it deliberry_api_php /bin/bash
composer install
composer recipes
bin/console doctrine:database:create
bin/console doctrine:schema:update --force