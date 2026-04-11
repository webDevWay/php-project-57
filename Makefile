#PORT ?= 8000

start:
	PHP artisan serve
	
install:
	composer install

validate:
	composer validate

autoload:
	composer dump-autoload

require:
	composer require
	
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src public

lint-fix:
	composer lint-fix