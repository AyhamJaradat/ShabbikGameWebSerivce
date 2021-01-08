<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/8/2021
 * Time: 5:26 PM
 */

namespace api\modules\v1\resources;


use common\models\Game;
use common\models\Round;
use yii\base\Model;

class AddGameForm extends Model
{

    public $firstUserId;
    public $secondUserId;
    public $gameMode;


    public function rules()
    {
        return [
            [['firstUserId','secondUserId','gameMode'],'integer'],
            [['firstUserId','secondUserId','gameMode'], 'required'],

            [['firstUserId'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => 'id'],
            [['secondUserId'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => 'id'],

        ];
    }

    public function addGame($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {

            return (object)array('status'=>false);
        }

        $game= new Game();
        $game->setAttributes([
            'gameMode'=>$this->gameMode, // need migration to be int
            'firstUserId'=>$this->firstUserId,
            'secondUserId'=>$this->secondUserId,
            'startDate'=>time()
        ]);
        $rounds = [];
        if($game->save()){
            $gameId = $game->id;


            for($i=1; $i<4;$i++){
                $round = new Round();
                $round->setAttributes([
                    'gameId'=>$gameId,
                    'roundNumber'=>$i,
                    'isFinished'=>0,
                ]);
                if($round->save()){
                    $rounds[] = $round;
                }
            }
        }else{
            return (object)array('status'=>false);
//            return $game->errors;
        }

        if(sizeof($rounds) != 3){
            // error
            foreach ($rounds as $curRound){
                $curRound->delete();
            }
            $game->delete();
            return (object)array('status'=>false);
        }else{
            // Good

            $gameObject = (object)array('id'=>$gameId, 'firstUserId'=>$game->firstUserId,
                'secondUserId'=>$game->secondUserId,'gameMode'=> $game->gameMode, 'timeString'=>$game->startDate."");

            //id, roundNumber, isFinished,gameId
            $round1 =(object)array('id'=>$rounds[0]->id, 'roundNumber'=>$rounds[0]->roundNumber,
                'isFinished'=>$rounds[0]->isFinished==1 ,'gameId'=>$gameId) ;
            $round2 = (object)array('id'=>$rounds[1]->id, 'roundNumber'=>$rounds[1]->roundNumber,
                'isFinished'=>$rounds[1]->isFinished==1 ,'gameId'=>$gameId) ;
            $round3 =(object)array('id'=>$rounds[2]->id, 'roundNumber'=>$rounds[2]->roundNumber,
                'isFinished'=>$rounds[2]->isFinished==1 ,'gameId'=>$gameId) ;


            return (object)array('status'=>true, 'arraySize'=>3,
                'gameObject'=>$gameObject,
                'gsonObject1'=>$round1,
                'gsonObject2'=>$round2,
                'gsonObject3'=>$round3);
        }

    }

}