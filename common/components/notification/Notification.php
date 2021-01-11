<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/9/2021
 * Time: 3:41 PM
 */

namespace common\components\notification;


use common\models\Game;
use common\models\PullNotification;
use common\models\Round;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class Notification extends Component
{

    public $apiLegacyServerKey;
    /**
     * @var string API url to google's FCM
     */
    public $apiUrl = 'https://fcm.googleapis.com/fcm/send';

    public function init()
    {

        // get legacy server key from env file
//        $this->apiLegacyServerKey = Yii::$app->params['notifServerKey'];
        // Validate config
        $attributeKeys = ['apiLegacyServerKey'];
        $this->validateConfig($attributeKeys);

        // Parent
        return parent::init();
    }

    /**
     * Make sure all attributes are present
     * @param array $attributeKeys
     * @throws InvalidConfigException
     */
    private function validateConfig(array $attributeKeys): void
    {
        foreach ($attributeKeys as $configKey) {
            if ($this->$configKey === null) {
                throw new InvalidConfigException('"' . get_class($this) . '::' . $configKey . '" is missing');
            }
        }
    }

    public function sendFirstUserNotification(Round $round){
        $title = "titleOfNotif";
        $body ="body";

        //secondUserGCMKey
        $fcm_token = "";

        //TODO: Insert new notification in notification table and get the id

        $game = Game::find()->where(['id'=>$round->gameId])->one();
//        $gameObject = (object)array('id'=>$game->id, 'firstUserId'=>$game->firstUserId,
//            'secondUserId'=>$game->secondUserId,'gameMode'=> $game->gameMode, 'timeString'=>$game->startDate."");

        $firstUser = $game->firstUser;
        // id fname,lnamekey, fb
//        $firstUserObject = (object)array('id'=>$firstUser->id, 'userFirstName'=>$firstUser->firstName,
//            'userLastName'=>$firstUser->lastName,'userKey'=> $firstUser->userKey, 'userFBId'=>$firstUser->faceBookId);

        //
//        $secondUser = $game->secondUser;
        $fcm_token = $firstUser->userKey;
        // game rounds
//        $rounds = Round::find()->where(['gameId'=>$game->id])->all();
//
//
//
//        $round1 =(object)array('id'=>$rounds[0]->id, 'roundNumber'=>$rounds[0]->roundNumber,
//            'isFinished'=>$rounds[0]->isFinished==1 ,'gameId'=>$game->id , 'firstUserScore'=>$rounds[0]->firstUserScore,
//            'secondUserScore'=>$rounds[0]->secondUserScore,'roundSentence'=>$rounds[0]->roundSentence,
//            'roundConfigration'=>$rounds[0]->gameConfiguration) ;
//        $round2 = (object)array('id'=>$rounds[1]->id, 'roundNumber'=>$rounds[1]->roundNumber,
//            'isFinished'=>$rounds[1]->isFinished==1 ,'gameId'=>$game->id, 'firstUserScore'=>$rounds[1]->firstUserScore,
//            'secondUserScore'=>$rounds[1]->secondUserScore,'roundSentence'=>$rounds[1]->roundSentence,
//            'roundConfigration'=>$rounds[1]->gameConfiguration) ;
//        $round3 =(object)array('id'=>$rounds[2]->id, 'roundNumber'=>$rounds[2]->roundNumber,
//            'isFinished'=>$rounds[2]->isFinished==1 ,'gameId'=>$game->id, 'firstUserScore'=>$rounds[2]->firstUserScore,
//            'secondUserScore'=>$rounds[2]->secondUserScore,'roundSentence'=>$rounds[2]->roundSentence,
//            'roundConfigration'=>$rounds[2]->gameConfiguration) ;

        $currRoundObj = (object)array('id'=>$round->id, 'roundNumber'=>$round->roundNumber,
            'isFinished'=>$round->isFinished==1 ,'gameId'=>$game->id , 'firstUserScore'=>$round->firstUserScore,
            'secondUserScore'=>$round->secondUserScore,'roundSentence'=>$round->roundSentence,
            'roundConfigration'=>$round->gameConfiguration) ;


        // insert new pull notification
        $pullNotif = new PullNotification();
        $pullNotif->setAttributes([
            'roundId'=>$round->id,
            'whoAmI'=> 1,
            'userId'=>$firstUser->id,
            'notificationStatus'=>0
        ]);
        $notificationId =0;
        if($pullNotif->save()){
            $notificationId = $pullNotif->id;
        }


        $notifData = [
//            'notification_type' => $type,
            'badge' => 0,
            'whichUserAmI'=>1,
//            'roundNumber'=>$round->roundNumber,
//            'roundId'=>$round->id,
            'notificationId'=>$notificationId,
            'roundObject' => $currRoundObj

        ];
//        if($round->roundNumber ==1 ){
//
//            $notifData['gameObject'] = $gameObject;
//            $notifData['userObject'] = $firstUserObject;
//            $notifData['arraySize'] = 3; // three rounds
//            $notifData['gsonObject1'] = $round1;
//            $notifData['gsonObject2'] = $round2;
//            $notifData['gsonObject3'] = $round3;
//        }else{
//
//            $notifData['roundObject'] = $currRoundObj;
//        }


        $data = [
            "to" => $fcm_token,
            "priority" => "normal",
            "data" => $notifData,
        ];

        $lastNotificationResult = $this->postToFcm($data);

        return $lastNotificationResult;
    }

    /**
     * Send notification about round From firstUser to second User the user
     * should check whoAmI and roundNumber
     * @param $round
     */
    public function sendSecondUserNotification(Round $round){

        //Android data object :
        /*

          object = [
                    "to" => $device->fcm_token,
                    "priority" => "normal",
                     "data" => [
                                  'notification_type' => $type,
                                   'badge' => 0,
                                    'title'=> '',
                                    'body'=> ''
                                ],
                   ]
         */


        $title = "titleOfNotif";
        $body ="body";

        //secondUserGCMKey
        $fcm_token = "";

        //TODO: Insert new notification in notification table and get the id

        $game = Game::find()->where(['id'=>$round->gameId])->one();
        $gameObject = (object)array('id'=>$game->id, 'firstUserId'=>$game->firstUserId,
            'secondUserId'=>$game->secondUserId,'gameMode'=> $game->gameMode, 'timeString'=>$game->startDate."");
//        $firstUser = $game->getFirstUser()->one();
        $firstUser = $game->firstUser;
        // id fname,lnamekey, fb
        $firstUserObject = (object)array('id'=>$firstUser->id, 'userFirstName'=>$firstUser->firstName,
            'userLastName'=>$firstUser->lastName,'userKey'=> $firstUser->userKey, 'userFBId'=>$firstUser->faceBookId);

        //
        $secondUser = $game->secondUser;
        $fcm_token = $secondUser->userKey;
        // game rounds
        $rounds = Round::find()->where(['gameId'=>$game->id])->all();
        //id, roundNumber, ,gameId ,firstUserScore,secondUserScore,gameConfiguration,roundSentence,startDate
//        not added : isFinished


        $round1 =(object)array('id'=>$rounds[0]->id, 'roundNumber'=>$rounds[0]->roundNumber,
            'isFinished'=>$rounds[0]->isFinished==1 ,'gameId'=>$game->id , 'firstUserScore'=>$rounds[0]->firstUserScore,
            'secondUserScore'=>$rounds[0]->secondUserScore,'roundSentence'=>$rounds[0]->roundSentence,
            'roundConfigration'=>$rounds[0]->gameConfiguration) ;
        $round2 = (object)array('id'=>$rounds[1]->id, 'roundNumber'=>$rounds[1]->roundNumber,
            'isFinished'=>$rounds[1]->isFinished==1 ,'gameId'=>$game->id, 'firstUserScore'=>$rounds[1]->firstUserScore,
            'secondUserScore'=>$rounds[1]->secondUserScore,'roundSentence'=>$rounds[1]->roundSentence,
            'roundConfigration'=>$rounds[1]->gameConfiguration) ;
        $round3 =(object)array('id'=>$rounds[2]->id, 'roundNumber'=>$rounds[2]->roundNumber,
            'isFinished'=>$rounds[2]->isFinished==1 ,'gameId'=>$game->id, 'firstUserScore'=>$rounds[2]->firstUserScore,
            'secondUserScore'=>$rounds[2]->secondUserScore,'roundSentence'=>$rounds[2]->roundSentence,
            'roundConfigration'=>$rounds[2]->gameConfiguration) ;

        $currRoundObj = (object)array('id'=>$round->id, 'roundNumber'=>$round->roundNumber,
            'isFinished'=>$round->isFinished==1 ,'gameId'=>$game->id , 'firstUserScore'=>$round->firstUserScore,
            'secondUserScore'=>$round->secondUserScore,'roundSentence'=>$round->roundSentence,
            'roundConfigration'=>$round->gameConfiguration) ;


        // insert new pull notification
        $pullNotif = new PullNotification();
        $pullNotif->setAttributes([
            'roundId'=>$round->id,
            'whoAmI'=> 2,
            'userId'=>$secondUser->id,
            'notificationStatus'=>0
        ]);
        $notificationId =0;
        if($pullNotif->save()){
            $notificationId = $pullNotif->id;
        }


        $notifData = [
//            'notification_type' => $type,
            'badge' => 0,
            'whichUserAmI'=>2,
            'roundNumber'=>$round->roundNumber,
            'roundId'=>$round->id,
            'notificationId'=>$notificationId,

        ];
        if($round->roundNumber ==1 ){

             $notifData['gameObject'] = $gameObject;
             $notifData['userObject'] = $firstUserObject;
             $notifData['arraySize'] = 3; // three rounds
             $notifData['gsonObject1'] = $round1;
             $notifData['gsonObject2'] = $round2;
             $notifData['gsonObject3'] = $round3;
        }else{

            $notifData['roundObject'] = $currRoundObj;
        }
//        if ($title)
//            $notifData['title'] = $title;
//        if ($body)
//            $notifData['body'] = $body;

        $data = [
            "to" => $fcm_token,
            "priority" => "normal",
            "data" => $notifData,
        ];

        $lastNotificationResult = $this->postToFcm($data);

        return $lastNotificationResult;

    }


    public function sendTestNotification(){

        //Android data object :
        /*

          object = [
                    "to" => $device->fcm_token,
                    "priority" => "normal",
                     "data" => [
                                  'notification_type' => $type,
                                   'badge' => 0,
                                    'title'=> '',
                                    'body'=> ''
                                ],
                   ]
         */

        $type="typeof notification as you want";
        $title = "titleOfNotif";
        $objectId = "objectId";
        $toUserId ="d";
        $body ="body";
        $toBusinessId = "s";
        $fcm_token = "cnMtZuliTzyFP7s6xXlpZ-:APA91bEYM6g2XJCwYHtm8MNn-sG6nYeB3n4SqtD0GALw8LGpd_a8LLS7aoNTAw5uP22HZmyh-zXxUJU2ahqMEvCx_-edPTR5O0_TibULVEF3QWKM1j0Wqa3Z1wQBGwhQnuR2Ux3QcxKE";

        $data = [
            'notification_type' => $type,
            'badge' => 0,
        ];
        if ($title)
            $data['title'] = $title;
        if ($objectId)
            $data['object_id'] = $objectId;
        // send user Id because it is needed to open business card of a user
        $data['second_object_id'] =$toUserId;
        if ($body)
            $data['body'] = $body;
        if ($toBusinessId)
            $data['business_id'] = $toBusinessId;
        $data = [
            "to" => $fcm_token,
            "priority" => "normal",
            "data" => $data,
        ];

        $lastNotificationResult = $this->postToFcm($data);

        return $lastNotificationResult;

    }

    protected function postToFcm( array $data)
    {

        // always send push notification using background task

//        $id = Yii::$app->queue->push(new SendAsyncPushNotificationJob([
//            'apiUrl'=>$this->apiUrl,
//            'apiLegacyServerKey'=>$this->apiLegacyServerKey,
//            'data'=>$data
//        ]));
//        return true;

        $client = new Client([
            'baseUrl' => $this->apiUrl
        ]);
//
        $request = $client->createRequest()
            ->setMethod('POST')
            ->setFormat(Client::FORMAT_JSON)
            ->setData($data);

        $headers = $request->getHeaders()
            ->add('Content-Type', 'application/json')
//        ->add('Authorization', 'key='.$this->apiKey);
            ->add('Authorization', 'key=' . $this->apiLegacyServerKey);

        return $request->send();
    }
}