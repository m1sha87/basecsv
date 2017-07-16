<?php

namespace app\components\categoryWidget;

use yii\web\AssetBundle;

class CategoryWidgetAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . "/assets";
    
    public $js = [
        'js/category.js',
    ];
    
    public $css = [
        'css/category.css',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function init()
    {
        parent::init();
    }
}