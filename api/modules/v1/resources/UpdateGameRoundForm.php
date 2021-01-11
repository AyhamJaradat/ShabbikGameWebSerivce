<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/9/2021
 * Time: 12:25 PM
 */

namespace api\modules\v1\resources;


use common\models\Round;
use yii\base\Model;
use Yii;

class UpdateGameRoundForm extends Model
{

    public $whichUserAmI; //int 1 or 2
    public $roundId;
    public $roundScore;
    public $roundConfig;
    public $roundSentence;// int index of sentance




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roundConfig'], 'filter', 'filter' => 'trim'],
            [['whichUserAmI','roundId','roundScore'], 'required'],
            [['roundScore','roundId','whichUserAmI','roundSentence'], 'integer'],
            [['roundId'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\Round', 'targetAttribute' => 'id'],
            ['roundConfig', 'string'],
        ];
    }


    public function updateRound($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }
        $round = Round::find()->where(['id'=>$this->roundId])->one();

        if(!$round){
            return false;
        }

        if($this->whichUserAmI == Round::I_AM_FIRST_USER){

            $round->setAttributes([
                'firstUserScore'=>$this->roundScore,
                'startDate'=> time(),
                'gameConfiguration'=>$this->roundConfig,
                'roundSentence'=>$this->roundSentence,
            ]);
            if($round->save()){
                $round->refresh();
                // send push notifications
                $response = Yii::$app->notification->sendSecondUserNotification($round);
                return $round;
            }

        }else if($this->whichUserAmI == Round::I_AM_SECOND_USER){
            $round->setAttributes([
                'secondUserScore'=>$this->roundScore,
                'startDate'=> time()
            ]);
            if($round->save()){
                $round->refresh();
                // send push notifications
                $response = Yii::$app->notification->sendFirstUserNotification($round);

                return $round;
            }
        }else{
            return false;
        }


    }

}