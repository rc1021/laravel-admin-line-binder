<div style="text-align: center;">
    <a href="readme.md">English</a>
    <span>|</span>
    <a href="readme-zh_TW.md">中文版</a>
    <span>|</span>
    日本語
</div>

## laravel-admin Line Notify Binder

> 
> このドキュメントはGoogle翻訳からのものです
> 

これは、[Line Notify](https://notify-bot.line.me/zh_TW/) と[Laravel-admin](https://github.com/z-song/laravel-admin) を統合するためのパッケージです。

![altスナップショット](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/snapshot.png)

## インストール

このパッケージはcomposerで必要です。

```shell
composer require rc1021/laravel-admin-line-binder
```

LaravelはPackageAuto-Discoveryを使用するため、ServiceProviderを手動で追加する必要はありません。

### 自動検出なしのLaravel

自動検出を使用しない場合は、config /app.phpのproviders配列にServiceProviderを追加します

```php
Rc1021\LaravelAdmin\ServiceProvider::class,
```

### `config.services` の `line` キーにクレデンシャルを追加します。

Line Notifyを介してサービスをバインドするには、 `config/services.php` の `line` キーに[credentials](https://notify-bot.line.me/my/services/new)を追加する必要があります。

```php
'line' => [
    'client_id' => env('LINE_NOTIFY_CLIENT_ID', ''),
    'client_secret' => env('LINE_NOTIFY_SECRET', ''),
],
```

### publishコマンドを使用してパッケージ構成をローカル構成にコピーします。

```shell
php artisan vendor:publish --provider="Rc1021\LaravelAdmin\ServiceProvider"
```

### そしてデータベースを移行します：

```shell
php artisan migrate
```

### そしてみんなへの新しい許可：

![alt New Permission](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/add_premission.png)

## 使用法

`App\Admin\Controllers\AuthController` の `settingForm()` メソッドをオーバーライドし、次のコードを追加する必要があります

```php
protected function settingForm()
{
    $form = parent::settingForm();
    $form->linenotify();
    return $form;
}
```

## 補助

現在ログインしているユーザーのトークンを取得します

```php
currentLineNotifyToken();
```

バインドURLを取得

```php
lineNotifyBinderUrl();
```

取り消しURLを取得する

```php
lineNotifyRevokeUrl();
```