## laravel-admin Line Notify Binder

This is a package to integrate [Line Notify](https://notify-bot.line.me/zh_TW/) with [Laravel-admin](https://github.com/z-song/laravel-admin).

## Installation

Require this package with composer.

```shell
composer require rc1021/laravel-admin-line-binder
```

Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Add credentials in the `line` key of `config.services`:

In order to bind service via Line Notify, you need to add credentials in the `line` key of `config/services.php`.

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

## Usage

You need to override the settingForm() method in `App\Admin\Controllers\AuthController` and add the following code

```php
protected function settingForm()
{
    $form = parent::settingForm();
    $form->linenotify('line_notify_token', Admin::user()->id);
    return $form;
}
```