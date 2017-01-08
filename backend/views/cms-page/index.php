<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CmsPagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cms Pages';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-sm-12 card card-box">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p class="pull-right">
            <?= Html::a('Create Cms Pages', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'table table-striped'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'title',
                'seo_url:url',
                //'description:ntext',
                'meta_title',
                // 'meta_description',
                // 'meta_keywords',
                // 'seo_keywords',
                [
                    'attribute' => 'bottom',
                    'value' => function($model) {
                        return ($model->bottom == 1 ? 'Yes' : 'No');
                    },
                ],
                [
                    'attribute' => 'top',
                    'value' => function($model) {
                        return ($model->top == 1 ? 'Yes' : 'No');
                    },
                ],
                'sort_order',
                // 'banner_image',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>

</div>
