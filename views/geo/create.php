<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Geo */

$this->title = 'Create Geo';
$this->params['breadcrumbs'][] = ['label' => 'Geos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
