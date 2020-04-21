<?php

namespace backend\widgets;

use common\models\Basket;
use common\models\Cities;
use common\models\Help;
use common\models\Lots;
use common\models\Search;
use common\models\Slider;
use common\models\Sliders;
use yii\base\Widget;
use Yii;
use yii\helpers\Html;

class Footer extends Widget
{


    public function run()
    {
        return $this->render('footer');
    }
}
