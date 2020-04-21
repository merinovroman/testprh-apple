<?php

namespace common\models;

use yii\base\Model;

/**
 * Class AppleGenerateForm
 *
 * @package common\models
 * @author Roman Merinov <merinovroman@gmail.com>
 */
class AppleGenerateForm extends Model
{

    public $quantity;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quantity' => 'Введите количество'
        ];
    }
}
