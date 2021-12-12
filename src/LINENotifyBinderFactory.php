<?php

namespace Rc1021\LaravelAdmin;

use Rc1021\LaravelAdmin\Exceptions\InvalidConfigurationException;
use Illuminate\Database\Eloquent\Model;

class LINENotifyBinderFactory
{
    protected $service;

    function __construct()
    {
        $service = collect(config('services.line'));
        if($service->isEmpty()) {
            throw InvalidConfigurationException::configurationNotSet();
        }
        $this->service = $service;
    }

    /**
     * laravel-admin user model
     *
     * @return string
     */
    public function UserModel()
    {
        return config('admin.database.users_model');
    }

    /**
     * getRoutePrefix
     *
     * @return void
     */
    public function getRoutePrefix()
    {
        return config('admin.route.prefix') ? config('admin.route.prefix') . '-' : '';
    }

    /**
     * getRouteNameForCancel
     *
     * @return void
     */
    public function getRouteNameForCancel()
    {
        return $this->getRoutePrefix().'line-notify.cancel';
    }

    /**
     * getRouteNameForCallback
     *
     * @return void
     */
    public function getRouteNameForCallback()
    {
        return $this->getRoutePrefix().'line-notify.callback';
    }

    /**
     * get line client id
     *
     * @return void
     */
    public function getClientID()
    {
        return $this->service->get('client_id');
    }

    /**
     * get line client secret
     *
     * @return void
     */
    public function getClientSecret()
    {
        return $this->service->get('client_secret');
    }
}
