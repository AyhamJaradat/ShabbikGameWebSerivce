<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/7/2021
 * Time: 10:02 PM
 */

namespace api\modules\v1\controllers;

use api\modules\v1\resources\AddGameForm;
use api\modules\v1\resources\GeneralResponse;
use api\modules\v1\resources\SignupForm;
use api\modules\v1\resources\UpdateGameRoundForm;
use api\modules\v1\resources\UpdateUserForm;
use common\models\Game;
use common\models\PullNotification;
use common\models\Round;
use common\models\User;
use yii\base\Exception;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\rest\OptionsAction;
use Yii;

class ServiceController extends Controller
{
    /**
     * @var bool See details {@link \yii\web\Controller::$enableCsrfValidation}.
     */
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors = ArrayHelper::merge($behaviors, [
            'corsFilter' => [
                'class' => Cors::class,
            ]
        ]);

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['index'], $actions['view']);
        $actions['options'] = [
            'class' => OptionsAction::className(),
            'collectionOptions' => ['POST']
        ];
        return $actions;
    }

    public function actionSayHi()
    {
        return "Hi from Shabbik services";
//        $user = User::find()->one();
//        return $user;
    }

    /**
     * @return object
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignUp()
    {
        if (!\Yii::$app->request->isPost) {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new SignupForm();
//        $response = new GeneralResponse();


        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->signup();
        if ($results) {
//            $response->data = $results;
//            $response->status = true;
            $response = (object)array('status' => true, 'userId' => $results->id);
        } else {
//            $response->errors = $model->errors;
//            $response->status = false;
            $response = (object)array('status' => false, 'errorMsg' => "could not add this user");

        }
        return $response;
    }


    /**
     * @return object
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateUser()
    {
        if (!\Yii::$app->request->isPost) {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new UpdateUserForm();
//        $response = new GeneralResponse();


        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->updateUser();
        if ($results) {
//            $response->data = $results;
//            $response->status = true;
            $response = (object)array('status' => true, 'userId' => $results->id);
        } else {
//            $response->errors = $model->errors;
//            $response->status = false;
            $response = (object)array('status' => false, 'errorMsg' => "user is not registered");

        }
        return $response;
    }


    /**
     * @param $userid
     * @return object
     * @throws Exception
     */
    public function actionRandomUser($userid)
    {
        if (!\Yii::$app->request->isGet) {
            throw new Exception("Only Get request is allowed");
        }

        // find all users Except for first one and the given userid
        $users = User::find()->andWhere(['!=', 'id', $userid])
            ->andWhere(['!=', 'id', 1])->all();

        if (!$users || sizeof($users) <= 0) {
            // no enough users
            $response = (object)array('status' => false);
        } else {
            //        get random user from the list
            $k = array_rand($users);
            $user = $users[$k];

            $userObject = (object)array('id' => $user->id, 'userFirstName' => $user->firstName,
                'userLastName' => $user->lastName, 'userKey' => $user->userKey);

            $response = (object)array('status' => true, 'userObject' => $userObject);
        }


        return $response;
    }


    /**
     * @return object
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddGame()
    {
        if (!\Yii::$app->request->isPost) {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new AddGameForm();
//        $response = new GeneralResponse();


        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->addGame();
        return $results;
    }

    /**
     * @return object
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateGameRound()
    {
        if (!\Yii::$app->request->isPost) {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new UpdateGameRoundForm();

        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->updateRound();
        if ($results) {

            $response = (object)array('status' => true, 'roundDate' => $results->startDate . "");
        } else {

            $response = (object)array('status' => false);

        }
        return $response;
    }


    /**
     * @param $notifid
     * @return object
     * @throws Exception
     */
    public function actionNotifAck($notifid)
    {
        if (!\Yii::$app->request->isGet) {
            throw new Exception("Only Get request is allowed");
        }

//        find notification
        $pullNotif = PullNotification::find()->where(['id' => $notifid])->one();

        if ($pullNotif) {
            $pullNotif->setAttributes([
                'notificationStatus' => 1
            ]);
            if ($pullNotif->save()) {
                $response = (object)array('status' => true);
                return $response;
            }
        }
        $response = (object)array('status' => false);
        return $response;
    }

    /**
     * @param $userId
     * @return object
     * @throws Exception
     */
    public function actionPullNotif($userId)
    {
        if (!\Yii::$app->request->isGet) {
            throw new Exception("Only Get request is allowed");
        }

        //by default
        $response = (object)array('status' => false);

        $myNotif = PullNotification::find()->where([
            'userId' => $userId,
            'notificationStatus' => 0])->one();

        if (!$myNotif) {
            $response = (object)array('status' => true, 'notificationId' => -1);
        } else {
            $round = Round::find()->where(['id' => $myNotif->roundId])->one();
            $currRoundObj = (object)array('id' => $round->id, 'roundNumber' => $round->roundNumber,
                'isFinished' => $round->isFinished == 1, 'gameId' => $round->gameId, 'firstUserScore' => $round->firstUserScore,
                'secondUserScore' => $round->secondUserScore, 'roundSentence' => $round->roundSentence,
                'roundConfigration' => $round->gameConfiguration);
            if ($myNotif->whoAmI == 1) {
                // first user
                $response = (object)array('status' => true, 'notificationId' => $myNotif->id, 'whichUserAmI' => 1, 'roundObject' => $currRoundObj);
            } else {

                if ($round->roundNumber == 1) {

                    $game = Game::find()->where(['id'=>$round->gameId])->one();
                    $gameObject = (object)array('id'=>$game->id, 'firstUserId'=>$game->firstUserId,
                        'secondUserId'=>$game->secondUserId,'gameMode'=> $game->gameMode, 'timeString'=>$game->startDate."");

                    $firstUser = $game->firstUser;
                    // id fname,lnamekey, fb
                    $firstUserObject = (object)array('id'=>$firstUser->id, 'userFirstName'=>$firstUser->firstName,
                        'userLastName'=>$firstUser->lastName,'userKey'=> $firstUser->userKey, 'userFBId'=>$firstUser->faceBookId);

                    $rounds = Round::find()->where(['gameId'=>$game->id])->all();

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


                    $response = (object)array('status' => true, 'notificationId' => $myNotif->id, 'whichUserAmI' => 2,
                        'roundNumber' => $round->roundNumber, 'roundId' => $round->id,
                        'gameObject'=>$gameObject,
                        'userObject'=>$firstUserObject,
                        'arraySize'=>3,
                        'gsonObject1'=> $round1,
                        'gsonObject2'=>$round2,
                        'gsonObject3'=>$round3);

                } else {
                    $response = (object)array('status' => true, 'notificationId' => $myNotif->id, 'whichUserAmI' => 2,
                        'roundNumber' => $round->roundNumber, 'roundId' => $round->id, 'roundObject' => $currRoundObj);

                }

            }


        }

        return $response;
    }

    public function actionTestNotif()
    {

        $response = Yii::$app->notification->sendTestNotification();
        return $response;
    }


}