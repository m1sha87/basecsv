<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'parent_id')->hiddenInput(['id' => 'categoryId'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <p>Выберите родительскую категорию:</p>
    
    <?=\app\components\categoryWidget\CategoryWidget::widget([
        'root' => 0,
        'current' => $model->parent_id,
        'hide' => $model->id,
    ]);?>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $('.category-widget').on('afterSelectCategory', function (e, item) {
        $('#categoryId').val($(item).data('id'));
    });
</script>
