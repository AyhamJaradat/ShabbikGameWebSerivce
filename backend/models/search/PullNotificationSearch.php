<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PullNotification;

/**
 * PullNotificationSearch represents the model behind the search form about `common\models\PullNotification`.
 */
class PullNotificationSearch extends PullNotification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'roundId', 'whoAmI', 'userId', 'notificationStatus', 'created_at', 'updated_at'], 'integer'],
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
        $query = PullNotification::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'roundId' => $this->roundId,
            'whoAmI' => $this->whoAmI,
            'userId' => $this->userId,
            'notificationStatus' => $this->notificationStatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
