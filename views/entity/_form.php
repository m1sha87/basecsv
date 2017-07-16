<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'part' => 'Part', 'assembly' => 'Assembly', 'product' => 'Product', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['id' => 'categoryId'])->label(false); ?>
    
    <p>Выберите категорию:</p>
    
    <?=\app\components\categoryWidget\CategoryWidget::widget([
        'model' => new \app\models\Category(),
        'root' => 1,
        'current' => $model->category_id,
    ]);?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
    

</div>
