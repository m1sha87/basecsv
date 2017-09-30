<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entity */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="entity-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'part' => 'Part', 'assembly' => 'Assembly', 'product' => 'Product', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['id' => 'widgetCategoryField'])->label(false); ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <p>Выберите категорию:</p>
    
    <?=\app\components\categoryWidget\CategoryWidget::widget([
        'root' => 1,
        'current' => $model->category_id,
    ]);?>
    
    <?php ActiveForm::end(); ?>
    

</div>
