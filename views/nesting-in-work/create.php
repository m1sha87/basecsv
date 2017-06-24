<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NestingInWork */

$this->title = 'Create Nesting In Work';
$this->params['breadcrumbs'][] = ['label' => 'Nesting In Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nesting-in-work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
