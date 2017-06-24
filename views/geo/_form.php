<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Geo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="geo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'x')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'y')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>