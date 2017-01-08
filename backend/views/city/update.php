<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cities */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cities',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="row">
    <div class="cities-update">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
