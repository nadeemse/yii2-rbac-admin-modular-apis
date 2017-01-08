<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="card card-box">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="header">
            <h4 class="title">Accounts</h4>
        </div>
        <div class="content table-responsive table-full-width">

            <div class="col-sm-12">
                <p class="pull-right">
                    <?= Html::a('Create Accounts', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'first_name',
                    'last_name',
                    'email:email',
                    'account_type',
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return $model->status == 0 ? 'In-Active' : 'Active';
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>
