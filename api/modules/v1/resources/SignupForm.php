<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/7/2021
 * Time: 10:11 PM
 */

namespace api\modules\v1\resources;


use yii\base\Model;
use Yii;
use yii\base\Exception;
class SignupForm extends Model
{

//    public $username;
//    public $email;
//    public $password;
    // from Android
    public $userFirstName;
    public $userLastName;
    public $userEmail;
    public $userFBId;
    public $userKey;

    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userFirstName','userLastName','userEmail','userFBId','userKey'], 'filter', 'filter' => 'trim'],
            [['userFirstName','userLastName','userEmail','userKey'], 'required'],
//            ['userEmail', 'unique',
//                'targetClass' => '\common\models\User',
//                'message' => Yii::t('frontend', 'This email has already been taken.')
//            ],
//            ['username', 'string', 'min' => 2, 'max' => 255],

            ['userEmail', 'filter', 'filter' => 'trim'],
            ['userEmail', 'required'],
            ['userEmail', 'email'],
            ['userEmail', 'unique',
                'targetClass' => '\common\models\User',
                'targetAttribute' => 'email',
                'message' => Yii::t('frontend', 'This userEmail address has already been taken.')
            ],

            ['password', 'string'],
            [['password'], 'default', 'value' => "shabbikDefaultPass"],

        ];
    }

//    public function rules()
//    {
//        return [
//            [['is_liked','review_id'], 'required'],
//            [['like_as'], 'required', 'when' => function ($model) {
//                return $model->is_liked == 1;
//            }],
//            [['review_id','like_as','is_liked'], 'integer'],
//            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\modules\review\models\Review::className(), 'targetAttribute' => ['review_id' => 'id']],
//            [['like_as'], 'in',
//                'range' => [Constants::AS_ME, Constants::AS_ANONYMOUS],
//                'message' => 'like_as must be integer: either 1 for As Me or 2 for AsAnonymous '],
//            [['is_liked'], 'in',
//                'range' => [Constants::YES_OPTION, Constants::NO_OPTION],
//                'message' => 'is_liked must be integer: either 1 for YES or 0 for NO ']
//
//
//        ];
//    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return User|bool
     * @throws Exception
     */
    public function signup($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }

        // Check if already existing user has the same userKey
        $existingUser= \common\models\User::find()->where(['userKey'=>$this->userKey])->one();
        $existingUserEmail = \common\models\User::find()->where(['email'=>$this->userEmail])->one();

        if($existingUser){
            return $existingUser;
        }else if($existingUserEmail){
            return $existingUserEmail;
        }else{
            $shouldBeActivated = false;
            $user = new User();
            $user->firstName = $this->userFirstName;
            $user->lastName = $this->userLastName;
            $user->faceBookId = $this->userFBId;
            $user->userKey = $this->userKey;

//            $user->username = $this->username;
            $user->email = $this->userEmail;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if (!$user->save()) {
//                throw new Exception("User couldn't be  saved");
                return false;
            };
            $user->afterSignup();
//            if ($shouldBeActivated) {
//                $token = UserToken::create(
//                    $user->id,
//                    UserToken::TYPE_ACTIVATION,
//                    Time::SECONDS_IN_A_DAY
//                );
//                Yii::$app->commandBus->handle(new SendEmailCommand([
//                    'subject' => Yii::t('frontend', 'Activation email'),
//                    'view' => 'activation',
//                    'to' => $this->email,
//                    'params' => [
//                        'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
//                    ]
//                ]));
//            }
            return $user;
        }
    }



}