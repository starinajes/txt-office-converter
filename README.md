# Конвертер адресов
Превращает txt в json, xml

## Старт
```terminal
docker compose up --build
docker compose up -d
docker compose exec php-app php converter convert:json storage/offices.txt 
docker compose exec php-app php converter convert:xml storage/offices.txt 
```

Или без docker в cli
```php
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