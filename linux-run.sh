#!/bin/bash

echo "[+] Uploading Application Container"
docker-compose up -d

echo [+] Copying the configuration example file
docker exec -it task-manager-app cp .env.example .env
docker exec -it task-manager-app cp .env.example.testing .env.testing

echo [+] Installing the dependencies
docker exec -it task-manager-app composer install

echo [+] Generating key
docker exec -it task-manager-app php artisan key:generate

sleep 30

echo [+] Creating database for tests
docker exec -it task-manager-mysql mysql -u root -ptaskmanager_pass -e "CREATE DATABASE IF NOT EXISTS taskmanager_db_testing;" -f

echo [+] Ensuring user access to test database
docker exec -it task-manager-mysql mysql -u root -ptaskmanager_pass -e "GRANT ALL ON taskmanager_db_testing.* TO 'taskmanager_user'@'%' IDENTIFIED BY 'taskmanager_pass';"

echo [+] Making migrations
docker exec -it task-manager-app php artisan migrate

echo [+] Information of new containers
docker ps -a