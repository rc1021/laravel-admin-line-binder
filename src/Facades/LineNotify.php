<?php

namespace Rc1021\LaravelAdmin\Facades;

use Illuminate\Support\Facades\Facade;
use Rc1021\LaravelAdmin\LINENotifyBinderFactory;

/**
 * LineNotify.
 *
 * @method static string UserModel()
 * @method static string getRoutePrefix()
 * @method static string getRouteNameForCancel()
 * @method static string getRouteNameForCallback()
 * @method static string getClientID()
 * @method static string getClientSecret()
 * @method static string getBinderUrl()
 * @method static string getRevokeUrl()
 * @method static string|null currentLineNotifyToken()
 *
 * @see \Rc1021\LaravelAdmin\LINENotifyBinderFactory
 */
class LineNotify extends Facade
{
    protected static function getFacadeAccessor() { return LINENotifyBinderFactory::class; }
}