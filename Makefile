up:
	docker-compose \
		-f infrastructure/docker-compose.yml \
		up -d --build --remove-orphans
	docker exec php-fpm mkdir -p /application/var/sessions
	docker exec php-fpm mkdir -p /application/var/log
	docker exec php-fpm chmod -R 777 /application/var/sessions
	docker exec php-fpm chmod -R 777 /application/var/log
php:
	docker exec -it php-fpm bash
