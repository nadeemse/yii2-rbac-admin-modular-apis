<?php

use yii\widgets\Menu;
use common\helpers\MenuHelper;

?>
<div class="sidebar" data-background-color="black" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/" class="simple-text">
                YII2 Admin
            </a>
        </div>
        <?php
        echo Menu::widget([
            'items' => MenuHelper::getMenu(),
            'encodeLabels' => false,
            'options' => ['class' => 'nav'],
        ]);
        ?>


    </div>
</div>