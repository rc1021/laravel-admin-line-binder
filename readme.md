<div style="text-align: center;">
    English
    <span>|</span>
    <a href="readme-zh_TW.md">中文版</a>
    <span>|</span>
    <a href="readme-ja.md">日本語</a>
</div>

## laravel-admin Line Notify Binder

This is a package to integrate [Line Notify](https://notify-bot.line.me/zh_TW/) with [Laravel-admin](https://github.com/z-song/laravel-admin).

![alt Snapshot](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/snapshot.png)

## Installation

Require this package with composer.

```shell
composer require rc1021/laravel-admin-line-binder
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Rc1021\LaravelAdmin\ServiceProvider::class,
```

### Add credentials in the `line` key of `config.services`:

In order to bind service via Line Notify, you need to add [credentials](https://notify-bot.line.me/my/services/new) in the `line` key of `config/services.php`.

```php
'line' => [
    'client_id' => env('LINE_NOTIFY_CLIENT_ID', ''),
    'client_secret' => env('LINE_NOTIFY_SECRET', ''),
],
```

### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Rc1021\LaravelAdmin\ServiceProvider"
```

### And migrate database:

```shell
php artisan migrate
```

### And new permission to everyone:

![alt New Permission](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/add_premission.png)

## Usage

You need to override the settingForm() method in `App\Admin\Controllers\AuthController` and add the following code

```php
protected function settingForm()
{
    $form = parent::settingForm();
    $form->linenotify();
    return $form;
}
```

## Helper

Get the token of the currently logged in user

```php
currentLineNotifyToken();
```

Get Line Notify bind url

```php
lineNotifyBinderUrl();
```

Get Line Notify revoke url

```php
lineNotifyRevokeUrl();
```