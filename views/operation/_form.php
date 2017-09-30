<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Area;

/* @var $this yii\web\View */
/* @var $model app\models\Operation */
/* @var $form yii\bootstrap\ActiveForm */

$areas = Area::find()->select(['id', 'name'])->asArray()->all();
?>

<div class="operation-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'areas')->checkboxList(array_column($areas, 'name'), ['separator' => '</br>']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
