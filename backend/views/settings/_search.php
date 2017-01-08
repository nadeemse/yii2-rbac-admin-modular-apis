<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SettingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'app_name') ?>

    <?= $form->field($model, 'app_owner') ?>

    <?= $form->field($model, 'admin_email') ?>

    <?= $form->field($model, 'from_email') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'app_logo') ?>

    <?php // echo $form->field($model, 'footer_logo') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'Geocode') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'copyright_text') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'meta_title') ?>

    <?php // echo $form->field($model, 'meta_tag') ?>

    <?php // echo $form->field($model, 'meta_tag_description') ?>

    <?php // echo $form->field($model, 'smtp_email') ?>

    <?php // echo $form->field($model, 'smtp_username') ?>

    <?php // echo $form->field($model, 'smtp_password') ?>

    <?php // echo $form->field($model, 'smtp_hash') ?>

    <?php // echo $form->field($model, 'smtp_port') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
