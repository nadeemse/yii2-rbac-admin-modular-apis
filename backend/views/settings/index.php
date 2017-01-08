<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="settings-index card card-box">


        <p class="pull-right">
            <?= Html::a('Create Settings', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'app_name',
                'app_owner',
                'admin_email:email',
                //'from_email:email',
                // 'address',
                // 'app_logo',
                // 'footer_logo',
                // 'currency',
                'location',
                // 'Geocode',
                'telephone',
                // 'copyright_text',
                // 'about:ntext',
                // 'meta_title',
                // 'meta_tag',
                // 'meta_tag_description',
                // 'smtp_email:email',
                // 'smtp_username',
                // 'smtp_password',
                // 'smtp_hash',
                // 'smtp_port',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>
</div>

