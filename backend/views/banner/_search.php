<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BannersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'type')->dropDownList([ 'home' => 'Home', 'category' => 'Category', 'product' => 'Product', 'blog' => 'Blog', 'other' => 'Other', ], ['prompt' => 'Select Type']) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'status')->dropDownList(['0' => 'In-active', '1' => 'Active'], ['prompt' => 'Select status']) ?>
        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
