setup:
	@make docker-up-build
	@make composer-install
	@make set-permissions
	@make setup-env
	@make generate-key
	@make migrate
	@make db-seed
	@make npm-install
	@make npm-run-prod

docker-stop:
	docker compose stop

docker-up-build:
	docker compose up -d --build

composer-install:
	docker exec elibrary-app bash -c "composer install"

composer-update:
	docker exec elibrary-app bash -c "composer update"

npm-install:
	docker exec elibrary-app bash -c "npm install"

npm-run-prod:
	docker exec elibrary-app bash -c "npm run prod"

set-permissions:
	docker exec elibrary-app bash -c "chmod -R 777 /var/www/storage"
	docker exec elibrary-app bash -c "chmod -R 777 /var/www/bootstrap"

setup-env:
	docker exec elibrary-app bash -c "cp .env.docker .env"

generate-key:
	docker exec elibrary-app bash -c "php artisan key:generate"

migrate:
	docker exec elibrary-app bash -c "php artisan migrate:fresh"

db-seed:
	docker exec elibrary-app bash -c "php artisan db:seed"
