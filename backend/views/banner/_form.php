<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="banners-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'home' => 'Home', 'category' => 'Category', 'product' => 'Product', 'other' => 'Other', ], ['prompt' => 'Select Type']) ?>

    <?= $form->field($model, 'status')->dropDownList(['0' => 'In-active', '1' => 'Active'], ['prompt' => 'Select status']) ?>

    <table id="images" class="table table-striped table-bordered table-hover images-table upload-preview">
        <thead>
        <tr>
            <td class="text-left">Title</td>
            <td class="text-left">Description</td>
            <td class="text-left">Href(Link)</td>
            <td class="text-left">Image</td>
            <td class="text-right">Sort Order</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php $image_row = 0; ?>
        <?php foreach ($model->bannerImages as $BannerImages) { ?>
            <tr id="image-row<?php echo $image_row; ?>">

                <td class="">
                    <div class="form-group">
                        <input type="text" name=Banners[images][<?php echo $image_row; ?>][title]" value="<?= $BannerImages->title ?>" placeholder="Title" class="form-control" />
                    </div>
                </td>

                <td class="">
                    <div class="form-group">
                        <input type="text" name="Banners[images][<?php echo $image_row; ?>][description]" value="<?= $BannerImages->description ?>" placeholder="description" class="form-control" />
                    </div>
                </td>

                <td class="" style="width: 30%;">
                    <input type="text" name="Banners[images][<?php echo $image_row; ?>][link]" value="<?= $BannerImages->link; ?>" placeholder="Href (Link)" class="form-control" />
                </td>

                <td class="">
                    <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                        <img src="<?php echo Yii::$app->params['ASSET_URL'].$BannerImages->image; ?>" alt="" title="" data-placeholder="<?php echo $BannerImages->image; ?>" />
                    </a>
                    <input type="hidden" name="Banners[images][<?php echo $image_row; ?>][image]" value="<?php echo $BannerImages->image; ?>" id="input-image<?php echo $image_row; ?>" />
                </td>

                <td class="">
                    <div class="form-group">
                        <input type="text" name="Banners[images][<?php echo $image_row; ?>][sort_order]" value="<?php echo $BannerImages->sort_order; ?>" placeholder="Sort order" class="form-control" />
                    </div>
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
            <td colspan="5"></td>
            <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
        </tfoot>
    </table>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    var image_row = <?= $image_row ?>;

    function addImage() {
        html  = '<tr id="image-row'+ image_row +'">';
        html += '<td>';
        html += '    <div class="form-group">';
        html += '      <input type="text" name="Banners[images][' + image_row + '][title]" value="" placeholder="Title" class="form-control" />';
        html += '    </div>';
        html += '  </td>';

        html += '  <td class="">';
        html += '    <div class="form-group">';
        html += '      <input type="text" name="Banners[images][' + image_row + '][description]" value="" placeholder="description" class="form-control" />';
        html += '    </div>';
        html += '  </td>';

        html += '  <td class="" style="width: 30%;">';
        html += '    <div class="form-group">';
        html += '       <input type="text" name="Banners[images][' + image_row + '][link]" value="" placeholder="Href (Link)" class="form-control" />';
        html += '    </div>';
        html += '  </td>';

        html += '  <td class=""><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?= Yii::getAlias('@web').'/images/no_image.png' ?>" alt="" title="" data-placeholder="<?= Yii::getAlias('@web').'/images/no_image.png' ?>" /></a><input type="hidden" name="Banners[images][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';

        html += '  <td style="width: 10%;">';
        html += '    <div class="form-group">';
        html += '   <input type="text" name="Banners[images][' + image_row + '][sort_order]" value="" placeholder="Sort order" class="form-control" />';
        html += '    </div>';
        html += '  </td>';

        html += '  <td class=""><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

        html += '</tr>';

        $('#images tbody').append(html);

        image_row++;
    }
</script>
