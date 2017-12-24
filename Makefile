cs:
	./vendor/bin/php-cs-fixer fix --verbose

cs_dry_run:
	./vendor/bin/php-cs-fixer fix --verbose --dry-run

test:
	rm -rf tests/functional/fixtures/var/cache/* && ./vendor/bin/simple-phpunit
