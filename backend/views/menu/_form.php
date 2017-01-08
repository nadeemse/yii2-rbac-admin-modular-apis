<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'parent')->dropDownList( ArrayHelper::map( Menu::find()->where(['parent' => null])->all(), 'id', 'name' ), ['prompt' => 'Select Parent']) ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'data')->dropDownList([ 'In-Active', 'Active' ], ['prompt' => 'Select Status']) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
