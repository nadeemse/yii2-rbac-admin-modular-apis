<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CmsPages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-pages-form">

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
                    <a href="#configuration" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Configuration</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="general">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'seo_url')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'id' => "elm1"]) ?>

                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6, 'maxlength' => true]) ?>

                    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>

                </div>

                <div class="tab-pane" id="configuration">

                    <div id="images" class="form-group">
                        <label class="control-label" for="input-image">Banner Image</label>
                        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                            <img src="<?= $model->banner_image; ?>" alt="" width="125" height="125" title="" data-placeholder="no_image.png" />
                        </a>
                        <input type="hidden" name="CmsPages[banner_image]" value="<?php echo $model->banner_image; ?>" id="input-image" />

                    </div>

                    <?= $form->field($model, 'bottom')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Bottom']) ?>

                    <?= $form->field($model, 'top')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Top']) ?>

                    <?= $form->field($model, 'sort_order')->textInput() ?>

                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'In-Active'], ['prompt' => 'Select Status']) ?>

                </div>

            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
