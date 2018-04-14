<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NestingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $uploadModel \app\models\UploadForm */

$this->title = 'Nestings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nesting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Nesting', ['create'], ['class' => 'btn btn-success']) ?>
        <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]) ?>
        <?= $form->field($uploadModel, 'jobFile')->fileInput() ?>
        
        <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
    
        <?php ActiveForm::end() ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'size',
            'time',
            [
                'label' => 'Geo',
                'value' => function($model) {
                    return Html::ol($model->geos, ['item' => function($item, $index) {
                        return Html::tag(
                            'li', Html::a("{$item->name}x{$item->count}", ['geo/view', 'id' => $item->id])
                        );
                    }]);
                },
                'format' => 'raw',
            ],
            'tools:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
