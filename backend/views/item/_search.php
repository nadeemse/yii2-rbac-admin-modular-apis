<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Accounts;
use app\models\Categories;
use app\models\ItemAges;
use app\models\ItemUsages;
use app\models\ItemConditions;
use app\models\Areas;


/* @var $this yii\web\View */
/* @var $model app\models\itemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'price') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'seller_id')->dropDownList(ArrayHelper::map(Accounts::find()->where(['status' => 1])->all(), 'id', 'email'), ['prompt' => 'Select Seller']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Categories::find()->all(), 'id', 'name'), ['prompt' => 'Select Category']) ?>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-3">
            <?php echo $form->field($model, 'area_id')->dropDownList(ArrayHelper::map(Areas::find()->all(), 'id', 'name'), ['prompt' => 'Select Area']) ?>

        </div>
        <div class="col-sm-3">
            <?php echo $form->field($model, 'status')->dropDownList(['Deleted', 'Active', 'Awaiting Approval', 'Suspended'], ['prompt' => 'Select Status']) ?>
        </div>
    </div>




    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'seo_url') ?>

    <?php // echo $form->field($model, 'meta_title') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'area_id') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <div class="com-sm-12">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
