<div style="text-align: center;">
    <a href="readme.md">English</a>
    <span>|</span>
    中文版
    <span>|</span>
    <a href="readme-ja.md">日本語</a>
</div>

## laravel-admin Line Notify 綁定功能

此套件增加 [Line Notify 綁定](https://notify-bot.line.me/zh_TW/) 到 [Laravel-admin](https://github.com/z-song/laravel-admin) 的用戶資料。

![alt Snapshot](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/snapshot.png)

## 安裝

執行指令加入套件

```shell
composer require rc1021/laravel-admin-line-binder
```

Laravel 會自動發件此套件，所以不需要在 ServiceProvider 手動加入，如果是比較舊的版本請手動註冊。

### 手動註冊套件

如果使用手動註冊，請將 ServiceProvider 加入 config/app.php 的 `providers` 陣列中

```php
Rc1021\LaravelAdmin\ServiceProvider::class,
```

### 加入 Line Notify 的服務金鑰

請將你在 Line Notify 登入服務得到的 [金鑰](https://notify-bot.line.me/my/services/new) 使用 `line` 當陣列索引加入 `config/services.php` 

```php
'line' => [
    'client_id' => env('LINE_NOTIFY_CLIENT_ID', ''),
    'client_secret' => env('LINE_NOTIFY_SECRET', ''),
],
```

### 發佈套件必要項目

```shell
php artisan vendor:publish --provider="Rc1021\LaravelAdmin\ServiceProvider"
```

### 執行 migrate:

```shell
php artisan migrate
```

### 登入 laravel-admin，在 Permission 選單加入兩項路由到所有用戶

![alt New Permission](https://raw.githubusercontent.com/rc1021/laravel-admin-line-binder/master/add_premission.png)

## 使用方法

你需要覆寫在 `App\Admin\Controllers\AuthController` 裡的 settingForm() 方法，內容如下：

```php
protected function settingForm()
{
    $form = parent::settingForm();
    $form->linenotify();
    return $form;
}
```

## 輔助函數

取得目前登入用戶的權杖

```php
currentLineNotifyToken();
```

取得目前登入用戶綁定網址

```php
lineNotifyBinderUrl();
```

取得目前用戶解除連動網址

```php
lineNotifyRevokeUrl();
```