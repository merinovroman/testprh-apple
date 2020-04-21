<?php
use yii\helpers\Url;
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">НАВИГАЦИЯ</li>
            <li class="<?= Yii::$app->controller->id=="apple"?"active":"" ?>">
                <a href="<?= Url::to(['apple/index']) ?>">
                    <i class="fa fa-th"></i> <span>Яблоки</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li><a href="<?= Url::to(['site/logout']) ?>"><i class="fa fa-power-off"></i><span>Выйти</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>