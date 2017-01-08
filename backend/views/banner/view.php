<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="card card-box">

        <p class="pull-right">
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
                'name',
                'type',
                [
                    'attribute' => 'status',
                    'value' =>  ($model->status == 1 ? 'Active' : 'In-active'),
                ],
            ],
        ]) ?>

        <h3>Images</h3>
        <?= GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getBannerImages(),
                'pagination' => [
                    'pageSize' => 10,
                ]]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'description',
                'image',
                'link',
                'sort_order',
                [
                    'attribute' => 'status',
                    'value' => function($model) {
                        return ($model->status == 1 ? 'Active' : 'In-active');
                    }
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>

</div>
