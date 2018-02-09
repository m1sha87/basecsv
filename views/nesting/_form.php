<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\time\TimePicker;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Nesting */
/* @var $modelsGeos app\models\NestingHasGeo */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="nesting-form">

    <?php $form = ActiveForm::begin(['id' => 'nesting-form']); ?>
    
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'x')->textInput(['id' => 'x']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'y')->textInput(['id' => 'y']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="param-list" id="size-list">
                        <?php foreach ($model::getSizes() as $size) : ?>
                            <?= Html::a($size) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 's')->textInput(['id' => 's']) ?>
            <div class="param-list" id="thickness-list">
                <?php foreach ($model::getThickness() as $thickness) : ?>
                    <?= Html::a($thickness) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'material')->textInput(['id' => 'material']) ?>
            <div class="param-list" id="material-list">
                <?php foreach ($model::getMaterials() as $material) : ?>
                    <?= Html::a($material) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div style="width: 190px;">
    <?= $form->field($model, 'time')->widget(TimePicker::className(),
        [
            'pluginOptions' => [
                'showSeconds' => true,
                'minuteStep' => 1,
                'secondStep' => 1,
                'showMeridian' => false,
                'defaultTime' => date('H:i:s', strtotime('0:01:00')),
                'showInputs' => true,
            ],
            'options'=>[
                'class'=>'form-control',
            ],
        ]); ?>
    </div>
    
    <?= $form->field($model, 'tools')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= $form->field($model, 'category_id')->hiddenInput(['id' => 'categoryId'])->label(false); ?>
        <label for="categoryName">Выбранная категория</label>
        <input type="text" class="form-control" id="categoryName" readonly>
    </div>
    
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.geo-item', // required: css class
        'limit' => 999, // the maximum times, an element can be cloned (default 999)
        'min' => $modelsGeos[0]->geo_id ? 1 : 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsGeos[0],
        'formId' => 'nesting-form',
        'formFields' => [
            'count'
        ],
    ]); ?>
    <div class="container-items"><!-- widgetBody -->
        <?php foreach ($modelsGeos as $i => $item) : ?>
        <div class="geo-item row">
            <div class="col-xs-4">
                <?php
                if (! $item->isNewRecord) {
                    echo Html::activeHiddenInput($item, "[{$i}]id");
                }
                echo Html::activeHiddenInput($item, "[{$i}]geo_id", ['class' => 'geo-id']);
                ?>
                <div class="geo-name">
                    <?= !empty($item->geo) ? $item->geo->name : '' ?>
                </div>
            </div>
            <div class="col-xs-2">
                <?= $form->field($item, "[{$i}]count")->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-xs-2">
                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    
    <?=\app\components\categoryWidget\CategoryWidget::widget([
        'main' => 2,
        'types' => ['geo', 'nesting'],
        'current' => $model->category_id,
        'toolbar' => $this->render('toolbar'),
    ]);?>
    
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var tmpName;
    var tmpId;
    
    $('#material-list').find('a').on('click', function () {
        $('#material').val($(this).text());
    });

    $('#thickness-list').find('a').on('click', function () {
        $('#s').val($(this).text());
    });

    $('#size-list').find('a').on('click', function () {
        var sizes = $(this).text().split('x');
        $('#x').val(sizes[0]);
        $('#y').val(sizes[1]);
    });

    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        tmpId = item.data('id');
        tmpName = item.data('name');
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $(item).find('.geo-id').val(tmpId);
        $(item).find('.geo-name').text(tmpName);
        refreshAddButtons();
    });

    $(".dynamicform_wrapper").on("afterDelete", function(e) {
        refreshAddButtons();
    });

    $(".dynamicform_wrapper").on("limitReached", function(e, item) {
        alert("Limit reached");
    });

    var firstClick = false;
    $('.category-widget').on('afterAddItems', function (e, item) {
        refreshAddButtons();
        if (!firstClick)
            $('#categorySelect').trigger('click');
        firstClick = true;
    });

    function refreshAddButtons() {
        $('.add-item').show();
        $('.geo-id').each(function () {
            var id = $(this).val();
            $('.add-item[data-id="'+id+'"]').hide();
        });
    }
    
    
</script>