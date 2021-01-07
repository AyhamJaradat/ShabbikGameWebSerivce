<?php
/**
 * Created by PhpStorm.
 * User: Ayham
 * Date: 1/7/2021
 * Time: 10:09 PM
 */

namespace api\modules\v1\resources;


use yii\base\Model;

class GeneralResponse extends Model
{

    public $status;
    public $data;
    public $errors;

}