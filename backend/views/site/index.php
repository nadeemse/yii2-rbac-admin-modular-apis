<?php

use app\models\Items;
use app\models\Accounts;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-warning text-center">
                            <i class="ti-server"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Await Approval</p>
                            <?= Items::find()->where(['status' => 2])->count() ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-reload"></i> <?= \yii\helpers\Html::a('Approve Now', ['/item']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-success text-center">
                            <i class="ti-wallet"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Active Items</p>
                            <?= Items::find()->where(['status' => 1])->count() ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-calendar"></i> <?= \yii\helpers\Html::a('View All', ['/item']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-danger text-center">
                            <i class="ti-user"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Customers</p>
                            <?= Accounts::find()->where(['account_type' => 'customer'])->count() ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-timer"></i> <?= \yii\helpers\Html::a('View All', ['/account']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-info text-center">
                            <i class="ti-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Sellers</p>
                            <?= Accounts::find()->where(['account_type' => 'seller'])->count() ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-reload"></i> Updated now
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Awaiting Approvals</h4>
            </div>
            <div class="content table-responsive table-full-width">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' =>  'image',
                            'format' => 'raw',
                            'value' => function($model) {
                                return \yii\helpers\Html::img($model->image, ['width' => 60]);
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
                        // 'age_id',
                        // 'usage_id',
                        // 'condition_id',
                        // 'description:ntext',
                        // 'image',
                        [
                            'attribute' => 'status',
                            'value' => function($model) {
                                return $model->getItemstatus();
                            }
                        ],
                        // 'created_at',
                        // 'updated_at',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'buttons'=>[
                                'update'=>function ($url, $model) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/item/update', 'id' => $model->id], ['class' => 'btn btn-success']);
                                },
                            ],
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Recently registered accounts</h4>
            </div>
            <div class="content table-responsive table-full-width">
                <?= GridView::widget([
                    'dataProvider' => $accountDataProvider,
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

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'buttons'=>[
                                'update'=>function ($url, $model) {
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/account/view', 'id' => $model->id], ['class' => 'btn btn-success']);
                                },
                            ],
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
