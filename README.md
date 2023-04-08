# Yandex-Cloud-Translate

Библиотека для интеграции с сервисом машинного перевода ["Yandex Translate"](https://cloud.yandex.ru/services/translate)

[![Packagist Downloads](https://img.shields.io/packagist/dt/tsyvkunov/yandex-cloud-translate)](https://packagist.org/packages/tsyvkunov/yandex-cloud-translate/stats)
![Packagist License](https://img.shields.io/packagist/l/tsyvkunov/yandex-cloud-translate)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/tsyvkunov/yandex-cloud-translate)

## Ссылки

* [Yandex Cloud](https://cloud.yandex.ru)
* [Документация (Yandex Cloud)](https://cloud.yandex.ru/docs)
* [Документация (Yandex Identity and Access Management)](https://cloud.yandex.ru/docs/iam/)
* [Документация (Yandex Translate)](https://cloud.yandex.ru/docs/translate/)

## Требования

* PHP >= 7.2
* Guzzle
* JSON
* mbstring

## Установка

```shell script
composer require tsyvkunov/yandex-cloud-translate
```

## Использование

### Создание сервиса / Аутентификация

* С аккаунтом на Яндексе (OAuth-токен)

```php
use Tsyvkunov\YandexCloudTranslate\Translate;

$translate = new Translate('oAuthToken', 'folderId');
```

* С использованием сервисного аккаунта / федеративного пользователя (IAM-токен)

```php
use Tsyvkunov\YandexCloudTranslate\Translate;

$translate = new Translate('iamToken');
```

* С использованием сервисного аккаунта (API-ключ)

```php
use Tsyvkunov\YandexCloudTranslate\Translate;

$translate = new Translate();
$translate->makeApi('apiKey');
```

### Перевод текста

```php
use Tsyvkunov\YandexCloudTranslate\Translate;

/*
 * Строка/массив строк для перевода
 * Язык, на который переводится текст
 * Язык, с которого переводится текст (необязательный параметр)
 */
print_r($translate->translate('Hello world', 'en'));
// ИЛИ
print_r($translate->translate(['Hello world', 'Well done'], 'en'));
```
