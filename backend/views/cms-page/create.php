<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CmsPages */

$this->title = 'Create Cms Pages';
$this->params['breadcrumbs'][] = ['label' => 'Cms Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-lg-12 card">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>
