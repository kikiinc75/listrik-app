# How to install Installation
- Run composer install (Inside project)
- then Run cp .env.example .env
- After that php artisan key:generate
- don't forget create database (your Database name) on phpmyadmin
- next step setting database on .env
- run php artisan migrate --seed
- the end php artisan serve
- Login admin - username : administrator - password : administrator
