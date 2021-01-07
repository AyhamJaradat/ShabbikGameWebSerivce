<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Game;

/**
 * GameSearch represents the model behind the search form about `common\models\Game`.
 */
class GameSearch extends Game
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'startDate', 'firstUserId', 'secondUserId', 'created_at', 'updated_at'], 'integer'],
            [['gameMode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Game::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'startDate' => $this->startDate,
            'firstUserId' => $this->firstUserId,
            'secondUserId' => $this->secondUserId,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gameMode', $this->gameMode]);

        return $dataProvider;
    }
}
