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