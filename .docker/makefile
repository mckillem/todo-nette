docker-up:
	docker-compose -p todo-nette up -d --build --force-recreate

docker-down:
	docker-compose -p todo-nette down

phpstan:
	docker exec todo-nette vendor/bin/phpstan analyse app