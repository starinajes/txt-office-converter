# Конвертер адресов
Превращает txt в json, xml

## Установка
```terminal
docker compose build app
docker compose up -d
docker compose exec offices-convert composer install
```

## Запуск приложения
```terminal
docker exec offices-convert php converter offices.txt to:json
docker exec offices-convert php converter offices.txt to:xml 
```

Или без docker в cli (php8.2)
```terminal
php converter offices.txt to:json
```

### Формат команды
```terminal
php converter [path-to-file] [command]
```

[path-to-file] — путь до файла.

    Пример: office.txt или inner/office.txt

    Файлы на вход храняться в папке /storage
    Файлы на выходе будут в папке /output

[command] - команда

    Прмер: to:json или to:xml

### Запуск тестов
```terminal
composer test tests
```

## Результат
В папке /output/ должны создаваться новые файлы в нужных форматах, с нужной вложенностью

### todo: 
- Model подключить к парсеру / форматерам
- докрутить test