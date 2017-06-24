<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NestingInWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nesting-in-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nesting_id')->textInput() ?>

    <?= $form->field($model, 'is_done')->textInput() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
