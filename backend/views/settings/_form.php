<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">

                <li class="active tab">
                    <a href="#general" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">General</span>
                    </a>
                </li>

                <li class="tab">
                    <a href="#settings" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Data</span>
                    </a>
                </li>

                <li class="tab">
                    <a href="#configuration" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Email setup</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="general">

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <?= $form->field($model, 'app_owner')->textInput(['maxlength' => true]) ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <?= $form->field($model, 'admin_email')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <?= $form->field($model, 'from_email')->textInput(['maxlength' => true]) ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'address')->textarea(['rows' => 6, 'maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'about')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>



                </div>

                <div class="tab-pane" id="settings">

                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label" for="input-image">Main Logo</label>
                            <a href="" id="thumb-image1" data-toggle="image" class="img-thumbnail">
                                <img src="<?php echo Yii::$app->params['ASSET_URL'].$model->app_logo; ?>" alt="" width="125" height="125" title="" data-placeholder="no_image.png" />
                            </a>
                            <input type="hidden" name="Settings[app_logo]" value="<?php echo $model->app_logo; ?>" id="input-image1" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label" for="input-image">Footer Logo</label>
                            <a href="" id="thumb-image2" data-toggle="image" class="img-thumbnail">
                                <img src="<?php echo Yii::$app->params['ASSET_URL'].$model->footer_logo; ?>" alt="" width="125" height="125" title="" data-placeholder="no_image.png" />
                            </a>
                            <input type="hidden" name="Settings[footer_logo]" value="<?php echo $model->footer_logo; ?>" id="input-image2" />
                        </div>
                    </div>

                    <?= $form->field($model, 'currency')->dropDownList(['USD' => 'United state Dollar'],['prompt' => 'Select Currency']) ?>

                    <?= $form->field($model, 'location')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Geocode')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'copyright_text')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meta_tag')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meta_tag_description')->textarea(['maxlength' => true]) ?>

                </div>

                <div class="tab-pane" id="configuration">


                    <?= $form->field($model, 'smtp_email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'smtp_username')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'smtp_password')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'smtp_hash')->dropDownList([ 'ssl' => 'Ssl', 'tls' => 'Tls', ], ['prompt' => 'Hash type']) ?>

                    <?= $form->field($model, 'smtp_port')->textInput() ?>

                </div>

            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
