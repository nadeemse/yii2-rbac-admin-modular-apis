<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="accounts-view card card-box">


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
                'first_name',
                'last_name',
                'dob',
                [
                    'attribute' => 'gender',
                    'value' => $model->status == 0 ? 'FeMale' : 'Male'
                ],
                [
                    'attribute' => 'country',
                    'value' => ( isset($model->accountCountry) ? $model->accountCountry->country_name : 'N/A' ),
                ],
                'email:email',
                'account_type',
                'auth_key',
                'password_hash',
                'password_reset_token',
                [
                    'attribute' => 'status',
                    'value' => $model->status == 0 ? 'In-Active' : 'Active'
                ],
                [
                    'attribute' => 'amazing_offers',
                    'value' => $model->status == 0 ? 'No' : 'Yes'
                ],
                [
                    'attribute' => 'occasional_updates',
                    'value' => $model->status == 0 ? 'No' : 'Yes'
                ],
                'created_at',
                'updated_at'
            ],
        ]) ?>

    </div>
</div>
