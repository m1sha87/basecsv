<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GeoSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="geo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'entity_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'count') ?>

    <?= $form->field($model, 'x') ?>

    <?php // echo $form->field($model, 'y') ?>

    <?php // echo $form->field($model, 's') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
