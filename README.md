# Конвертер адресов
Превращает txt в json, xml (cli interface) <br />

С 4ой версии можно принимать не только txt формат файлов <br />
Описание задачи находится в target.md <br />

## Установка
```terminal
docker compose up -d --build
```

## Запуск приложения
```terminal
docker exec offices-convert php converter convert offices.txt to:json
docker exec offices-convert php converter convert offices.txt to:xml 
```

Или в контейнере 
```terminal 
docker compose exec app bash
php converter convert offices.txt to:json
```

Или без docker в cli
```terminal
php converter convert offices.txt to:json
```

### Формат команды
```terminal
php converter [command] [path-to-file] [format]
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
