# Конвертер данных (txt/csv → json/xml)

CLI-инструмент для конвертации файлов с данными (офисы, машины и любые другие сущности) между форматами (txt, csv → json, xml).

---

## Важно

- **Без фреймворков:** проект написан на чистом PHP, без использования сторонних фреймворков (Symfony, Laravel и т.д.).
- **Изначальная задача** подробно описана в файле [target.md](./target.md).

---

## Основные возможности

- Поддержка разных типов сущностей (офисы, машины и др.)
- Возможность добавлять свои entity-сущности и парсеры для любых форматов (например, xml, yaml, html и др.)
- Поддержка разных форматов входных файлов (txt, csv)
- Поддержка разных форматов вывода (json, xml и любые другие)
- Можно явно указывать тип данных или использовать дефолтное поведение
- Возможность добавлять свои команды для CLI-интерфейса (например, свои утилиты, сервисные команды, генераторы и т.д.)

---

## Установка

```bash
docker compose up -d --build
```

---

## Запуск приложения

**В контейнере:**
```bash
docker exec offices-convert php converter convert offices.txt to:json
docker exec offices-convert php converter convert cars.csv to:xml
docker exec offices-convert php converter convert --type=car cars.txt to:json
```

**Внутри контейнера:**
```bash
docker compose exec app bash
php converter convert offices.txt to:json
php converter convert --type=car cars.txt to:json
```

**Без docker:**
```bash
php converter convert offices.txt to:json
php converter convert --type=car cars.txt to:json
```

---

## Формат команды

```bash
php converter convert [--type=тип] <путь_к_файлу> to:<формат>
```

- `[--type=тип]` — (опционально) явно указывает тип сущности (например, `car`, `office`).  
  Если не указан, будет использован дефолтный парсер по расширению/имени файла.
- `<путь_к_файлу>` — имя или путь к файлу (например, `offices.txt`, `cars.csv`, `inner/cars.txt`)
- `to:<формат>` — формат вывода (`json`, `xml`, `yaml`, ...)

**Примеры:**
- `php converter convert offices.txt to:json`
- `php converter convert cars.csv to:xml`
- `php converter convert --type=car cars.txt to:json`
- `php converter convert offices.txt to:yaml`

---

## Где хранятся файлы

- **Входные файлы:** папка `/storage` (и любые подпапки)
- **Выходные файлы:** папка `/output` (структура повторяет storage)

---

## Результат

В папке `/output/` будут появляться новые файлы в нужных форматах, с сохранением структуры из `/storage/`.

---

## Как добавить новую CLI-команду

В проекте реализован CommandRegistry, который позволяет легко добавлять свои команды в CLI.

1. **Создай класс-команду** и обработчик в `src/Application/Command/`, реализующий `CommandInterface`.
2. **Зарегистрируй команду** в `CommandRegistry`:
    - Добавь в массив `$commands` новую команду и функцию-фабрику для обработчика.
3. **Пример:**
   ```php
   // src/Application/Command/HelloWorldHandler.php
   readonly class HelloWorldHandler implements CommandInterface {
       public static function fromArgs(array $args): object { return new \stdClass(); }
       public function execute($config): string { return "Hello, world!"; }
   }
   // src/Application/Command/CommandRegistry.php
   self::$commands = [
       'convert' => fn() => new ConvertFileHandler(...),
       'hello'   => fn() => new HelloWorldHandler(),
   ];
   ```
4. **Вызови команду:**
   ```bash
   php converter hello
   ```

---

## Как добавить новый формат вывода (форматтер)

1. **Создай класс форматтера** в `src/Infrastructure/Formatter/`, реализующий интерфейс `FormatInterface` (например, `YamlFormat`, `CsvFormat`, `HtmlFormat`).
2. **Реализуй метод** `public function format(array $entities): string` — он должен принимать массив сущностей и возвращать строку в нужном формате.
3. **Добавь форматтер в фабрику** `FormatterFactory`:
    - В методе `create()` добавь новый case:
      ```php
      return match (strtolower($format)) {
          'json' => new JsonFormat(),
          'xml'  => new XmlFormat(),
          'yaml' => new YamlFormat(),
          // ...
          default => throw new Exception("Неизвестный формат: $format"),
      };
      ```
4. **Добавь тесты** для нового форматтера в `tests/Infrastructure/Formatter/`.
5. **Проверь работу через CLI:**
   ```bash
   php converter convert offices.txt to:yaml
   ```

---

## Как добавить новую сущность или формат

1. **Создай класс-сущность** в `src/Domain/<Entity>/Entity/` (например, `Product.php`), реализующий `EntityInterface` (лучше использовать `readonly class` и promotion).
2. **Создай парсер** для нужного формата (например, `XmlProductParser`, `YamlProductParser`, `HtmlProductParser` в `src/Infrastructure/Parser/`), реализующий `ParserInterface`.
   - Ты можешь реализовать парсер для любого формата, не только txt или csv.
   - В парсере определи, как из файла получить массив сущностей (например, из xml, yaml, html и т.д.).
3. **Добавь парсер в фабрику** (`ParserFactory`):
   - Для дефолтного поведения — по расширению/имени файла.
   - Для явного типа — в match по типу.
4. **(Опционально) Добавь форматтер** для специфичного вывода (если нужен особый формат json/xml/yaml и т.д.).
5. **Добавь тесты** для новых сущностей, парсеров и форматтеров.
6. **Проверь запуск через CLI**.

---

## Запуск тестов

```bash
composer test tests
```

---

## TODO (архитектурные планы и развитие)

- **Реализовать DI (Dependency Injection)** 
- **DDD:**
  - Выделить сервисы, репозитории, value-объекты, агрегации.
  - Domain, Application, Infrastructure, UI.
- **Web-интерфейс:**
  - роутеры, контроллеры, шаблоны
  - Возможность конвертации через web-форму
