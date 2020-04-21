<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class AppleSearch
 *
 * @package common\models
 * @author Roman Merinov <merinovroman@gmail.com>
 */
class AppleSearch extends Apple
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at', 'fall_at'], 'match', 'pattern' => "/\d{2}\.\d{2}\.\d{4}/"],
            [['color', 'status'], 'safe'],
            [['size'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = Apple::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'size' => $this->size,
        ]);

        if ($this->created_at) {
            list($dateObjFrom, $dateObjTo) = $this->getDatesObj($this->created_at);
            $query->andWhere(['between', 'created_at', $dateObjFrom->getTimestamp(), $dateObjTo->getTimestamp()]);
        }

        if ($this->fall_at) {
            list($dateObjFrom, $dateObjTo) = $this->getDatesObj($this->fall_at);
            $query->andWhere(['between', 'fall_at', $dateObjFrom->getTimestamp(), $dateObjTo->getTimestamp()]);
        }

        $query->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

    /**
     * @param $date
     * @return array
     */
    function getDatesObj($date): array
    {
        $dateObjFrom = \DateTime::createFromFormat('d.m.Y H:i:s', $date . " 00:00:00");
        $dateObjTo = \DateTime::createFromFormat('d.m.Y H:i:s', $date . " 23:59:59");
        return [$dateObjFrom, $dateObjTo];
    }
}
