<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Banners */

$this->title = 'Create Banners';
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="card card-box">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
