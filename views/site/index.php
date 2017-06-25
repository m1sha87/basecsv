<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="page-header">
        <h1>All controllers</h1>
    </div>

    <div class="body-content">

       <ul class="list-group">
           <li class="list-group-item"><a href="<?= Url::to('/area', true) ?>">Area</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/category', true) ?>">Category</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/color', true) ?>">Color</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/geo', true) ?>">Geo</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/entity', true) ?>">Entity</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/nesting', true) ?>">Nesting</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/nesting-in-work', true) ?>">Nesting in work</a></li>
           <li class="list-group-item"><a href="<?= Url::to('/operation', true) ?>">Operation</a></li>
       </ul>

    </div>
</div>
