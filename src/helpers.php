<?php

use Rc1021\LaravelAdmin\Facades\LineNotify;
use Encore\Admin\Facades\Admin;

if (! function_exists('lineNotifyBinderUrl')) {
    function lineNotifyBinderUrl()
    {
        return LineNotify::getBinderUrl();
    }
}

if (! function_exists('lineNotifyRevokeUrl')) {
    function lineNotifyRevokeUrl()
    {
        return LineNotify::getRevokeUrl();
    }
}

if (! function_exists('currentLineNotifyToken')) {
    function currentLineNotifyToken()
    {
        return LineNotify::currentLineNotifyToken();
    }
}