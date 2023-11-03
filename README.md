# Конвертер адресов
Превращает txt в json, xml

## Установка
```terminal
docker compose build app
docker compose up -d
docker compose exec app composer install
```

## Запуск приложения
```terminal
docker exec offices-convert php converter convert:json storage/offices.txt 
docker exec offices-convert php converter convert:xml storage/offices.txt 
```

Или без docker в cli (php8.2)
```terminal
php converter convert:json storage/offices.txt
```

### Запуск тестов
```terminal
composer test tests
```

## Результат
В папке /output/ должны создаваться новые файлы в нужных форматах

### todo: 
- Model подключить к парсеру / форматерам
- докрутить test