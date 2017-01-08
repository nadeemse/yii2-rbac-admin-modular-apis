<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6"> <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?></div>
    </div>


    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'id' => "elm1"]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList( ArrayHelper::map(Categories::find()->where(['parent_id' => 0])->all(), 'id', 'name'), ['prompt' => 'Select Category']) ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'In-Active'], ['prompt' => 'Select Status']) ?>

    <div id="images" class="form-group">
        <label class="control-label" for="input-image">Banner Image</label>
        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
            <img src="<?php echo $model->banner; ?>" alt="" width="125" height="125" title="" data-placeholder="no_image.png" />
        </a>
        <input type="hidden" name="Categories[banner]" value="<?php echo $model->banner; ?>" id="input-image" />

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
