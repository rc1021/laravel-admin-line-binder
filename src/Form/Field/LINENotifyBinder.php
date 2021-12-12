<?php

namespace Rc1021\LaravelAdmin\Form\Field;

use Encore\Admin\Form\Field;
use Encore\Admin\Form\Field\PlainInput;
use Illuminate\Support\Arr;
use Rc1021\LaravelAdmin\Facades\LineNotify;

class LINENotifyBinder extends Field
{
    use PlainInput;

    private $icon = 'fa-bell';

    protected $view = 'line::binder';

    protected static $css = [
    ];

    protected static $js = [
    ];

    /**
     * Line Notify 綁定物件
     *
     * @param mixed $column
     * @param array $arguments
     */
    public function __construct($column, $arguments)
    {
        array_unshift($arguments, __('line::admin.Line Notify'));
        parent::__construct($column, $arguments);

        $user_id = Arr::get($arguments, 1);
        $this->model = Arr::get($arguments, 2, LineNotify::UserModel());
        $this->attribute([
            'readonly' => true,
            'data-callbackurl' => route(LineNotify::getRouteNameForCallback(), ['id' => $user_id]),
            'data-cancelurl' => route(LineNotify::getRouteNameForCancel(), ['id' => $user_id]),
            'data-lineclientid' => LineNotify::getClientID()
        ]);
    }

    public function icon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function render()
    {
        $this->initPlainInput();

        $this->prepend("<i class='fa {$this->icon}'></i>")
            ->defaultAttribute('type', 'text')
            ->defaultAttribute('id', $this->id)
            ->defaultAttribute('name', $this->elementName ?: $this->formatName($this->column))
            ->defaultAttribute('value', old($this->column, $this->value()))
            ->defaultAttribute('class', 'form-control '.$this->getElementClassString())
            ->defaultAttribute('placeholder', $this->getPlaceholder());

        $status = $this->value() ? __('line::admin.Binder Cancel') : __('line::admin.Binder');
        $this->append("<a class='btn btn-default' href='javascript:;' onclick='oAuth2();' type='button'>{$status}</a>")
            ->defaultAttribute('grouptype', 'btn');

        $this->addVariables([
            'prepend' => $this->prepend,
            'append'  => $this->append,
            'cancelable' => $this->value()? 'true' : 'false'
        ]);

        $this->script = <<<EOT
EOT;

        return parent::render();
    }
}
