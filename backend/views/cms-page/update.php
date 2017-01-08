<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CmsPages */

$this->title = 'Update Cms Pages: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cms Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="cms-pages-update card card-box">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>


</div>