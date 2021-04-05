#!/bin/bash

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan queue:work &
echo "Queue Job started" &
php artisan serve --port=8000 &
php artisan serve --port=9001