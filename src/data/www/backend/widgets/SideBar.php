<?php

namespace backend\widgets;

use yii\base\Widget;

class SideBar extends Widget
{
    public function run()
    {
        return $this->render('sidebar');
    }
}
