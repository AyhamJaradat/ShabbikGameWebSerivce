<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/7/2021
 * Time: 10:02 PM
 */

namespace api\modules\v1\controllers;

use api\modules\v1\resources\GeneralResponse;
use api\modules\v1\resources\SignupForm;
use api\modules\v1\resources\UpdateUserForm;
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

    public function actionSayHi(){
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
        if(!\Yii::$app->request->isPost)
        {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new SignupForm();
//        $response = new GeneralResponse();


        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->signup();
        if ($results ) {
//            $response->data = $results;
//            $response->status = true;
            $response = (object)array('status'=>true, 'userId'=>$results->id);
        }else{
//            $response->errors = $model->errors;
//            $response->status = false;
            $response = (object)array('status'=>false, 'errorMsg'=>"could not add this user");

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
        if(!\Yii::$app->request->isPost)
        {
            throw new Exception("Only Post request is allowed");
        }
        // Set vars
        $request = Yii::$app->getRequest();
        $model = new UpdateUserForm();
//        $response = new GeneralResponse();


        // Load model
        $model->setAttributes($request->getBodyParams());
        $results = $model->updateUser();
        if ($results ) {
//            $response->data = $results;
//            $response->status = true;
            $response = (object)array('status'=>true, 'userId'=>$results->id);
        }else{
//            $response->errors = $model->errors;
//            $response->status = false;
            $response = (object)array('status'=>false, 'errorMsg'=>"user is not registered");

        }
        return $response;
    }

}