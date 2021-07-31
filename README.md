# MODx Evolution Console

Адаптированная под MODX Evolution https://github.com/darsain/laravel-console - Laravel 4 Console

AJAX Консоль для выполнения PHP кода в браузере с подсветкой, возможностью сохранения последнего выполненного кода, ограничением доступа по IP адресу

 Пример, вводим в окно редактора, нажимаем **Execute** `[Ctrl+Enter]`
 ```php
 echo get_class($modx);
 ```
 Результат
 ```php
 DocumentParser
 ```

## Установка
* Скопировать содержимое папки `assets` в одноименную папку вашего сайта
* Создать новый модуль с именем `Console` и след. содержимым:
```php
require_once MODX_BASE_PATH . 'assets/modules/console/module.tpl.php';
```

* Добавить список разрешенных / запрещенных IP адресов в assets/modules/console/config/config.php

```php
/* ... */
'whitelist' => [
    '127.0.0.1',
    '::1'
],

// или

'blacklist' => [
    '127.0.0.1',
    '::1'
],
/* ... */
```

Всё! Консоль должна быть доступна из административной панели на вкладке модули

Так же в консоле доступны все возможности MODX

! Чтобы открыть консоль в отдельной вкладке достаточно просто клацнуть средней кнопкой мышки по ссылке `Console` во вкладке Модули

Несколько скриншотов
![Console Before Execute](http://i66.fastpic.ru/big/2014/0926/cc/04dad01c556257b35477fb345322f2cc.jpg "Консоль до выполнеиня")
![Console After Execute](http://i66.fastpic.ru/big/2014/0926/14/a5253145c1931666d892ef8d73a97e14.jpg "Консоль после выполнеиня")

![Full Console Before Execute](http://i66.fastpic.ru/big/2014/0926/64/fca32624a3dc3e0ad7f9af3c35b17664.jpg "Консоль до выполнеиня")
![Full Console After Execute](http://i66.fastpic.ru/big/2014/0926/b0/ad2bc3f759313085605d2c59c760e2b0.jpg "Консоль после выполнеиня")
