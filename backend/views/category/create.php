<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = 'Create Categories';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-sm-12 card card-box">


        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
