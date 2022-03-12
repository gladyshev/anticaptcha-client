check-all: lint cs test

cs:
	composer cs-check

cs-fix:
	composer cs-fix

lint:
	composer lint

test:
	composer test

coverage:
	composer test-coverage