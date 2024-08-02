bash:
	docker-compose run --rm php bash
seed:
	docker-compose run --rm php php db/seeds.php
db-setup:
	docker-compose up -d && docker-compose exec db sh -c 'exec mysql -uroot -prootpassword < /docker-entrypoint-initdb.d/init.sql'