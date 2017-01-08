<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="card card-box">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="row">
    <div class="items-index card card-box">

        <p class="pull-right">
            <?= Html::a('Create Items', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' =>  'image',
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::img($model->image, ['width' => 60]);
                    }
                ],
                'name',
                'price',
                [
                    'attribute' => 'seller_id',
                    'value' => function($model) {

                        if( $model->seller ) {
                            return $model->seller->first_name . ' '. $model->seller->last_name;
                        } else {
                            return 'Developer';
                        }
                    }
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function($model) {
                        return $model->category->name;
                    }
                ],

                [
                    'attribute' => 'status',
                    'value' => function($model) {
                        return $model->getItemstatus();
                    }
                ],
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
