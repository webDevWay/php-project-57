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
	./vendor/bin/pint --preset psr12

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

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests database/seeders

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app tests database/seeders