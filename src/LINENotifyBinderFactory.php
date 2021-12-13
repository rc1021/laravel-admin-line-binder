<?php

namespace Rc1021\LaravelAdmin;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Rc1021\LaravelAdmin\Exceptions\InvalidConfigurationException;

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
    
    /**
     * getBinderUrl
     *
     * @return void
     */
    public function getBinderUrl()
    {
        $clientID = $this->getClientID();
        $user_id = Admin::user()->id;
        $url = route($this->getRouteNameForCallback(), ['id' => $user_id]);
        return "https://notify-bot.line.me/oauth/authorize?response_type=code&client_id={$clientID}&redirect_uri={$url}&scope=notify&state=NO_STATE";
    }
    
    /**
     * getRevokeUrl
     *
     * @return void
     */
    public function getRevokeUrl()
    {
        $user_id = Admin::user()->id;
        return route($this->getRouteNameForCancel(), ['id' => $user_id]);
    }
    
    /**
     * current user LineNotifyToken
     *
     * @return void
     */
    public function currentLineNotifyToken() 
    {
        return data_get(Admin::user(), 'line_notify_token', null);
    }
}
