<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="items-view card card-box">

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'price',
                [
                    'attribute' => 'seller_id',
                    'value' => ($model->seller ? ($model->seller->first_name . ' '. $model->seller->last_name) : 'Developer')
                ],
                [
                    'attribute' => 'category_id',
                    'value' => ($model->category->name)
                ],
                [
                    'attribute' => 'age_id',
                    'value' => ($model->itemAge->name)
                ],
                [
                    'attribute' => 'usage_id',
                    'value' => ($model->itemUsages->name)
                ],
                [
                    'attribute' => 'usage_id',
                    'value' => ($model->itemCondition->name)
                ],
                'description:ntext',
                'seo_url',
                'meta_title',
                'meta_description',
                'meta_keywords',
                [
                    'attribute' => 'image',
                    'format' => 'raw',
                    'value' => Html::img($model->image, ['width' => 400])
                ],
                [
                    'attribute' => 'status',
                    'value' => $model->getItemstatus()
                ],
                'created_at',
                'updated_at',
            ],
        ]) ?>


        <h3>Additional Images</h3>
        <table id="images" class="table table-striped table-bordered table-hover images-table upload-preview">
            <thead>
            <tr>
                <td class="text-left">Title</td>
                <td class="text-left">Image</td>
                <td></td>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($model->itemImages as $image) { ?>
                <tr id="image-row">

                    <td class="">
                        <?= $image->description ?>
                    </td>

                    <td class="">
                        <img src="<?= $image->image; ?>" width="150" />
                    </td>


                    <td class="text-left">
                    </td>
                </tr>

            <?php } ?>
            </tbody>

        </table>

    </div>
</div>
