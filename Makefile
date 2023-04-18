setup:
	cp ./parameters-example.json ./parameters.json
	docker compose up -d --build
	docker compose exec php-fpm composer install
	echo "Не забудьте проверить настройки в parameters.json"

up:
	docker compose up -d

down:
	docker compose down
