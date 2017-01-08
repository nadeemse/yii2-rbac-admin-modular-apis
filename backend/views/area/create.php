<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Areas */

$this->title = Yii::t('app', 'Create Areas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

</div>
<div class="areas-create card card-box">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
