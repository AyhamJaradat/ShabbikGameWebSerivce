<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Round;

/**
 * RoundSearch represents the model behind the search form about `common\models\Round`.
 */
class RoundSearch extends Round
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'roundNumber', 'firstUserScore', 'secondUserScore', 'startDate', 'isFinished', 'created_at', 'updated_at'], 'integer'],
            [['gameConfiguration', 'roundSentence'], 'safe'],
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
        $query = Round::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'gameId' => $this->gameId,
            'roundNumber' => $this->roundNumber,
            'firstUserScore' => $this->firstUserScore,
            'secondUserScore' => $this->secondUserScore,
            'startDate' => $this->startDate,
            'isFinished' => $this->isFinished,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gameConfiguration', $this->gameConfiguration])
            ->andFilterWhere(['like', 'roundSentence', $this->roundSentence]);

        return $dataProvider;
    }
}
