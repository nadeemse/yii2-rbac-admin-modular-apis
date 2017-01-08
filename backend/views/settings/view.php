<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="settings-view card card-box">

        <p class="pull-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'app_name',
                'app_owner',
                'admin_email:email',
                'from_email:email',
                'address',
                'app_logo',
                'footer_logo',
                'currency',
                'location',
                'Geocode',
                'telephone',
                'copyright_text',
                'about:ntext',
                'meta_title',
                'meta_tag',
                'meta_tag_description',
                'smtp_email:email',
                'smtp_username',
                'smtp_password',
                'smtp_hash',
                'smtp_port',
            ],
        ]) ?>

    </div>
</div>


