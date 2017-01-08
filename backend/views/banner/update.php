<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */

$this->title = 'Update Banners: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">

    <div class="card card-box">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
