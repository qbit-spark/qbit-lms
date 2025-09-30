setup:
	@make docker-up-build
	@make set-permissions
	@make setup-env
	@make generate-key
	@make migrate
	@make db-seed
	@make app-optimize

docker-stop:
	docker compose stop

docker-up-build:
	docker compose up -d --build

set-permissions:
	docker exec -it elibrary-app bash -c "chmod -R 777 /var/www/storage"
	docker exec -it elibrary-app bash -c "chmod -R 777 /var/www/bootstrap"

setup-env:
	docker exec -it elibrary-app bash -c "cp .env.docker .env"

generate-key:
	docker exec -it elibrary-app bash -c "php artisan key:generate"

migrate:
	docker exec -it elibrary-app bash -c "php artisan migrate"

db-seed:
	docker exec -it elibrary-app bash -c "php artisan db:seed"

app-optimize:
	docker exec -it elibrary-app bash -c "php artisan optimize:clear"
