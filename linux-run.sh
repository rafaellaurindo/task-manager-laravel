#!/bin/bash

echo "[+] Uploading Application Container"
docker-compose up -d

echo [+] Copying the configuration example file
docker exec -it task-manager-app cp .env.example .env

echo [+] Installing the dependencies
docker exec -it task-manager-app composer install

echo [+] Generating key
docker exec -it task-manager-app php artisan key:generate

echo [+] Making migrations
docker exec -it task-manager-app php artisan migrate

echo [+] Making seeds
docker exec -it task-manager-app php artisan db:seed

echo [+] Information of new containers
docker ps -a
