<?php

namespace Rc1021\LaravelAdmin\Form\Field;

use Encore\Admin\Form\Field;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field\PlainInput;
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
    public function __construct()
    {
        parent::__construct('line_notify_token', [__('line::admin.Line Notify')]);
        $this->attribute([
            'readonly' => true,
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
        $url = $this->value() ? LineNotify::getRevokeUrl() : LineNotify::getBinderUrl();
        $this->append("<a class='btn btn-default' href='{$url}' type='button'>{$status}</a>")
            ->defaultAttribute('grouptype', 'btn');
        $this->addVariables([
            'prepend' => $this->prepend,
            'append'  => $this->append,
        ]);

        $this->script = <<<EOT
EOT;

        return parent::render();
    }
}
