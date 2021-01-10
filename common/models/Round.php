<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%round}}".
 *
 * @property int $id
 * @property int $gameId
 * @property int $roundNumber
 * @property int $firstUserScore
 * @property int $secondUserScore
 * @property int $startDate
 * @property string $gameConfiguration
 * @property int $roundSentence
 * @property int $isFinished
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PullNotification[] $pullNotifications
 * @property Game $game
 */
class Round extends \yii\db\ActiveRecord
{

    const I_AM_FIRST_USER = 1;
    const I_AM_SECOND_USER = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%round}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'roundNumber'], 'required'],
            [['gameId', 'roundNumber', 'firstUserScore', 'secondUserScore', 'startDate','roundSentence', 'isFinished', 'created_at', 'updated_at'], 'integer'],
            [['gameConfiguration' ], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['gameId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gameId' => 'Game ID',
            'roundNumber' => 'Round Number',
            'firstUserScore' => 'First User Score',
            'secondUserScore' => 'Second User Score',
            'startDate' => 'Start Date',
            'gameConfiguration' => 'Game Configuration',
            'roundSentence' => 'Round Sentence',
            'isFinished' => 'Is Finished',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPullNotifications()
    {
        return $this->hasMany(PullNotification::className(), ['roundId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'gameId']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\RoundQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RoundQuery(get_called_class());
    }
}
