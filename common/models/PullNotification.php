<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pull_notification}}".
 *
 * @property int $id
 * @property int $roundId
 * @property int $whoAmI
 * @property int $userId
 * @property int $notificationStatus
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Round $round
 * @property User $user
 */
class PullNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pull_notification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['roundId', 'userId'], 'required'],
            [['roundId', 'whoAmI', 'userId', 'notificationStatus', 'created_at', 'updated_at'], 'integer'],
            [['roundId'], 'exist', 'skipOnError' => true, 'targetClass' => Round::className(), 'targetAttribute' => ['roundId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'roundId' => 'Round ID',
            'whoAmI' => 'Who Am I',
            'userId' => 'User ID',
            'notificationStatus' => 'Notification Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRound()
    {
        return $this->hasOne(Round::className(), ['id' => 'roundId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PullNotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PullNotificationQuery(get_called_class());
    }
}
