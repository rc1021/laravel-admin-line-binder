<?php

namespace Rc1021\LaravelAdmin\Exceptions;

use Exception;

class InvalidConfigurationException extends Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to bind service via Line Notify, you need to add credentials in the `line` key of `config/services.php`.');
    }
}
