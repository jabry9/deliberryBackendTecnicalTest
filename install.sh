/bin/bash

docker-compose build
docker-compose up -d
docker exec -it deliberry_api_php /bin/bash composer install
docker exec -it deliberry_api_php /bin/bash composer recipes
docker exec -it deliberry_api_php /bin/bash bin/console doctrine:database:create
docker exec -it deliberry_api_php /bin/bash bin/console doctrine:schema:update --force
docker exec -it deliberry_api_php /bin/bash bin/console doctrine:fixtures:load -n