<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property int $id
 * @property int $startDate
 * @property string $gameMode
 * @property int $firstUserId
 * @property int $secondUserId
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $firstUser
 * @property User $secondUser
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['startDate', 'firstUserId', 'secondUserId', 'created_at', 'updated_at'], 'integer'],
            [['gameMode', 'firstUserId', 'secondUserId'], 'required'],
            [['gameMode'], 'string', 'max' => 255],
            [['firstUserId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['firstUserId' => 'id']],
            [['secondUserId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['secondUserId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'startDate' => 'Start Date',
            'gameMode' => 'Game Mode',
            'firstUserId' => 'First User ID',
            'secondUserId' => 'Second User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirstUser()
    {
        return $this->hasOne(User::className(), ['id' => 'firstUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecondUser()
    {
        return $this->hasOne(User::className(), ['id' => 'secondUserId']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\GameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GameQuery(get_called_class());
    }
}
