setup:
	@make docker-up-build
	@make composer-install
	@make set-permissions
	@make setup-env
	@make generate-key
	@make migrate-fresh-seed
	@make npm-install
	@make npm-run-dev

docker-stop:
	docker compose stop

docker-up-build:
	docker compose up -d --build

composer-install:
	docker exec lms-app bash -c "composer install"

composer-update:
	docker exec lms-app bash -c "composer update"

set-permissions:
	docker exec lms-app bash -c "chmod -R 777 /var/www/storage"
	docker exec lms-app bash -c "chmod -R 777 /var/www/bootstrap"

setup-env:
	docker exec lms-app bash -c "cp .env.docker .env"

npm-install:
	docker exec lms-node bash -c "npm install"

npm-run-dev:
	docker exec lms-node bash -c "npm run prod"

generate-key:
	docker exec lms-app bash -c "php artisan key:generate"

migrate-fresh-seed:
	docker exec lms-app bash -c "php artisan migrate:fresh --seed"
