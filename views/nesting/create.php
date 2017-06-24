<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nesting */

$this->title = 'Create Nesting';
$this->params['breadcrumbs'][] = ['label' => 'Nestings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nesting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
