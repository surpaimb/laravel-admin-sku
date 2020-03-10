<?php

namespace Hanson\LaravelAdminSku;

use Encore\Admin\Form\Field;

class SkuField extends Field
{
    protected $view = 'sku::sku_field';

    protected static $js = [
        'vendor/hanson/sku/sku.js'
    ];

    protected static $css = [
        'vendor/hanson/sku/sku.css'
    ];

    public function render()
    {

        $this->script = <<< EOF
window.DemoSku = new JadeKunSKU('{$this->getElementClassSelector()}')
EOF;
        return parent::render();
    }

}
