# Клиент для Сервиса Комментариев "example.com"

## Описание проекта

Проект представляет собой библиотеку для взаимодействия с вымышленным сервисом комментариев "example.com". Эта библиотека позволяет выполнять HTTP-запросы к серверу для получения списка комментариев, добавления новых комментариев и обновления существующих комментариев по их идентификатору.

## Установка

Вы можете установить библиотеку через Composer, добавив следующую зависимость в ваш файл `composer.json`:

```json
{
    "require": {
        "ivolosevich/example-api-client": "^1.0"
    },
   "repositories": [
     {
       "type": "github",
       "url": "git@github.com:IrinaVolosevich/example-api-client.git"
     }
   ]
}
```

После этого выполните команду:

```bash
composer install
```

## Использование

### Инициализация клиента

Для начала работы с клиентом, вам необходимо создать экземпляр класса `CommentApiClient`. Вы можете передать собственные экземпляры Guzzle HTTP-клиента и конфигурации или использовать значения по умолчанию.

```php
use Ivolosevich\ExampleApiClient\API\CommentApiClient;
use Ivolosevich\ExampleApiClient\API\Configuration;

// Создание экземпляра клиента с конфигурацией по умолчанию
$commentApiClient = new CommentApi();

// Создание экземпляра клиента с собственными Guzzle HTTP-клиентом и конфигурацией
// $customClient = new \GuzzleHttp\Client();
// $customConfiguration = new Configuration();
// $commentApiClient = new CommentApi($customClient, $customConfiguration);
```

### Получение списка комментариев

Для получения списка комментариев вызовите метод `getAll`:

```php
try {
    $comments = $commentApiClient->getAll();
    
    foreach ($comments as $comment) {
        // Обработка комментария
        echo "ID: {$comment->getId()}, Name: {$comment->getName()}, Text: {$comment->getText()}\n";
    }
} catch (\Exception $e) {
    // Обработка ошибок
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Добавление нового комментария

Для добавления нового комментария вызовите метод `addComment` и передайте объект с полями `name` и `text`:

```php
use Ivolosevich\ExampleApiClient\API\CommentData;

$commentData = new CommentData('John Doe', 'This is a new comment');

try {
    $commentApiClient->addComment($commentData);
    echo "Comment added successfully!\n";
} catch (\Exception $e) {
    // Обработка ошибок
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Обновление комментария по идентификатору

Для обновления комментария по идентификатору вызовите метод `updateComment` и передайте идентификатор комментария и объект с обновляемыми полями:

```php
use Ivolosevich\ExampleApiClient\API\CommentData;

$commentId = 1;
$updatedCommentData = new CommentData('Updated Name', 'Updated Text');

try {
    $commentApiClient->updateComment($commentId, $updatedCommentData);
    echo "Comment updated successfully!\n";
} catch (\Exception $e) {
    // Обработка ошибок
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Объект CommentData

Объект `CommentData` используется для передачи данных при создании нового комментария или обновлении существующего. Он содержит два поля:

- `name` (тип string): Имя автора комментария.
- `text` (тип string): Текст комментария.

## Исключения

Библиотека может генерировать следующие исключения:

- `BadRequestException`: При получении HTTP-ответа с кодом 400 и наличием ошибок в теле ответа.
- `NotFoundException`: При получении HTTP-ответа с кодом 404 при обновлении комментария (опционально).
- `RemoteServiceException`: При других ошибках взаимодействия с сервером (например, отсутствие аутентификации, ошибки статуса и т.д.).
- `ConfigException`: При неверном конфигурировании клиента или запроса.

Эти исключения могут быть обработаны в вашем приложении для принятия соответствующих мер.

## Заключение

Библиотека предоставляет удобные методы для взаимодействия с вымышленным сервисом комментариев "example.com". Вы можете интегрировать эту библиотеку в свои проекты, используя Composer, и легко управлять комментариями в вашем приложении.