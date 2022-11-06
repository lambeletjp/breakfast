phpstan:
	vendor/bin/phpstan analyse src tests --level=9
fixture:
	php bin/console hautelook:fixtures:load -n
fixture-test:
	php bin/console hautelook:fixtures:load -n --env=test
test: fixture-test
	symfony php bin/phpunit