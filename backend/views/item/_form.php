<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Accounts;
use app\models\Categories;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs tabs">
                <li class="active tab">
                    <a href="#home-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">General</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#profile-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Data</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#seo-2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">SEO Data</span>
                    </a>
                </li>
                <li class="tab">
                    <a href="#messages-2" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                        <span class="hidden-xs">Images</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home-2">

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'id' => 'elm1']) ?>

                    <div id="images" class="form-group">
                        <label class="control-label" for="input-image">Main Image</label>
                        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                            <img src="<?= $model->image; ?>" alt="" width="125" height="125" title="" data-placeholder="no_image.png" />
                        </a>
                        <input type="hidden" name="Items[image]" value="<?php echo $model->image; ?>" id="input-image" />

                    </div>

                    <?php echo $form->field($model, 'status')->dropDownList(['Deleted', 'Active', 'Awaiting Approval', 'Suspended'], ['prompt' => 'Select Status']) ?>


                </div>
                <div class="tab-pane" id="profile-2">

                    <?= $form->field($model, 'seller_id')->dropDownList(
                        ArrayHelper::map(Accounts::find()->all(), 'id', function($model) {
                            return $model->first_name . ' '. $model->last_name;
                        })
                    , ['prompt' => 'Select Seller']) ?>

                    <?= $form->field($model, 'category_id')->dropDownList( ArrayHelper::map( Categories::find()->all(), 'id', 'name' ), ['prompt' => 'Select Category']) ?>

                </div>

                <div class="tab-pane" id="seo-2">

                    <?= $form->field($model, 'seo_url')->textInput() ?>
                    <?= $form->field($model, 'meta_title')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'meta_keywords')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

                </div>


                <div class="tab-pane" id="messages-2">

                    <table id="images" class="table table-striped table-bordered table-hover images-table upload-preview">
                        <thead>
                        <tr>
                            <td class="text-left">Title</td>
                            <td class="text-left">Image</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $image_row = 0; ?>
                        <?php foreach ($model->itemImages as $image) { ?>
                            <tr id="image-row<?php echo $image_row; ?>">

                                <td class="">
                                    <div class="form-group">
                                        <input type="text" name="Items[images][<?php echo $image_row; ?>][description]" value="<?= $image->description ?>" placeholder="description" class="form-control" />
                                    </div>
                                </td>

                                <td class="">
                                    <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                        <img src="<?= $image->image; ?>" alt="" title="" data-placeholder="<?php echo $image->image; ?>" />
                                    </a>
                                    <input type="hidden" name="Items[images][<?php echo $image_row; ?>][image]" value="<?php echo $image->image; ?>" id="input-image<?php echo $image_row; ?>" />
                                </td>


                                <td class="text-left">
                                    <button type="button" onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <?php $image_row++; ?>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                        </tfoot>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script type="text/javascript">
    var image_row = <?= $image_row ?>;

    function addImage() {
        html  = '<tr id="image-row'+ image_row +'">';

        html += '  <td class="">';
        html += '    <div class="form-group">';
        html += '      <input type="text" name="Items[images][' + image_row + '][description]" value="" placeholder="description" class="form-control" />';
        html += '    </div>';
        html += '  </td>';

        html += '  <td class=""><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= Yii::getAlias('@web').'/images/no_image.png' ?>" alt="" title="" data-placeholder="<?= Yii::getAlias('@web').'/images/no_image.png' ?>" /></a><input type="hidden" name="Items[images][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';

        html += '  <td class=""><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

        html += '</tr>';

        $('#images tbody').append(html);

        image_row++;
    }
</script>
