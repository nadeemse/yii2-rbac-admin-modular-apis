<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'first_name') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'last_name') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'gender')->dropDownList(['FeMale', 'Male'], ['prompt' => 'Select Gender']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'account_type')->dropDownList(['customer' => 'Customer', 'seller' => 'Seller'], ['prompt' => 'Select Type']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'country')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Country::find()->all(), 'id', 'country_name'), ['prompt' => 'Select Country']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(['In-Active', 'Active'], ['prompt' => 'Select Status']) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
