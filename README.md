# Lumen PHP Framework

## crear proyecto
composer create-project --prefer-dist laravel/lumen ejemplo

## inciar proyecto
php -S localhost:8000 -t public

## crear tabla libros en bd
php artisan make:migration libros --create=libros

## migrar
php artisan migrate

## rollback
php artisan migrate:rollback --step=3

ctrl shift p