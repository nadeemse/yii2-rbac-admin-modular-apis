<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cities */

$this->title = Yii::t('app', 'Create Cities');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="cities-create card card-box">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
