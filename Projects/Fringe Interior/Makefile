run:
	cp .env.example .env
	docker compose up --build --force-recreate -d
	docker exec -t barena_php bash -c "php artisan key:generate; php artisan test; php artisan migrate;php artisan route:list"
