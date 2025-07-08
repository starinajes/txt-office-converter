#!/bin/bash

cd /app

if [ -f "composer.json" ]; then
    echo "📦 Установка зависимостей..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
    composer dump-autoload
fi

exec "$@"