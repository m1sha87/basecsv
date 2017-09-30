<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nesting */
/* @var $modelsGeos app\models\NestingHasGeo */

$this->title = 'Update Nesting: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Nestings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nesting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsGeos' => $modelsGeos,
    ]) ?>

</div>
