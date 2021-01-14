<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/8/2021
 * Time: 11:37 AM
 */

namespace api\modules\v1\resources;


use yii\base\Model;

class UpdateUserForm extends Model
{

    public $userId;
    public $userFirstName;
    public $userLastName;
    public $userFBId;

    public function rules()
    {
        return [
            [['userFirstName','userLastName','userFBId'], 'filter', 'filter' => 'trim'],
            [['userFirstName','userFBId','userId'], 'required'],
            ['userId', 'integer'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => '\common\models\User', 'targetAttribute' => 'id'],
        ];
    }

    public function updateUser($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }

        // Check if already existing user has the same userKey
        $existingUser= \common\models\User::find()->where(['id'=>$this->userId])->one();


        if($existingUser){

            if($this->userLastName){
                $existingUser->setAttributes([
                    'firstName'=>$this->userFirstName,
                    'lastName'=>$this->userLastName,
                    'faceBookId'=>$this->userFBId,

                ]);
            }else{
                $existingUser->setAttributes([
                    'firstName'=>$this->userFirstName,
                    'faceBookId'=>$this->userFBId,
                ]);
            }

            $existingUser->save();
            $existingUser->refresh();
            return $existingUser;
        }else {
            return false;
        }
    }


}