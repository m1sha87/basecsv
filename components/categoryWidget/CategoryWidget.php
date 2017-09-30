<?php

namespace app\components\categoryWidget;

use yii\base\Widget;

class CategoryWidget extends Widget
{
    public $toolbar;
    public $root;
    public $main;
    public $current;
    public $hide;
    public $types;
    
    public function init()
    {
        parent::init();
        if ($this->root === null) {
            $this->root = 0;
        }
        if ($this->current === null) {
            $this->current = $this->root;
        }
    }
    
    public function run()
    {
        CategoryWidgetAsset::register($this->getView());
        return $this->render('category', ['model' => $this]);
    }
}