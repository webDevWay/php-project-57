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

	# Форматирование кода
pint:
	./vendor/bin/pint

	# Проверка форматирования (без сохранения)
pint-test:
	./vendor/bin/pint --test

	# Форматирование с детализацией
pint-verbose:
	./vendor/bin/pint -v

test:
	php artisan test

serve:
	php artisan serve

fresh:
	php artisan migrate:fresh --seed