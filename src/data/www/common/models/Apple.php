<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\base\Exception;

/**
 * Class Apple
 *
 * @property integer $id
 * @property string $color
 * @property integer $created_at
 * @property integer $fall_at
 * @property string $status
 * @property string $size
 *
 * @package common\models
 * @author Roman Merinov <merinovroman@gmail.com>
 */
class Apple extends ActiveRecord
{
    static $statusArr = [
        'hanging' => 'висит на дереве',
        'fall' => 'упало/лежит на земле',
        'rotten' => 'гнилое яблоко',
    ];

    public function __construct($color = false)
    {
        if ($color) $this->color = $color;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'fall_at'], 'integer'],
            [['status'], 'in', 'range' => ['hanging', 'fall', 'rotten']],
            [['size'], 'number'],
            [['color'], 'string', 'max' => 50],

            //Default Values
            ['status', 'default', 'value' => 'hanging'],
            ['size', 'default', 'value' => 1.00],
            ['created_at', 'default', 'value' => mt_rand(1, time())],
            ['color', 'default', 'value' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))],
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->status == "fall") {
            $this->fall_at = time();
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if ($this->status == "fall" && time() - $this->fall_at > 5 * 3600) {
            $this->status = "rotten";
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'created_at' => 'Дата появления',
            'fall_at' => 'Дата падения',
            'status' => 'Статус',
            'size' => 'Размер яблока',
        ];
    }

    /**
     * @param int $percent
     * @throws Exception
     */
    function eat(int $percent)
    {
        if ($percent > 100) {
            throw new Exception('Указан процент больше 100');
        } elseif ($percent < 0) {
            throw new Exception('Указан процент меньше 0');
        } elseif ($this->status == "hanging") {
            throw new Exception('Съесть нельзя, яблоко на дереве.');
        } elseif ($this->status == "rotten") {
            throw new Exception('Съесть нельзя, яблоко испорчено.');
        }
        $newSize = $percent / 100;
        if ($newSize > $this->size) {
            $this->size = 0.00;
        } else {
            $this->size -= $percent / 100;
        }
    }

    /**
     * @return void
     */
    function fallToGround()
    {
        $this->status = "fall";
    }
}
