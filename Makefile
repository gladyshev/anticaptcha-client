check-all: lint cs psalm test

cs:
	composer cs-check

cs-fix:
	composer cs-fix

psalm:
	composer psalm

lint:
	composer lint

test:
	composer test
