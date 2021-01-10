<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PullNotification */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="pull-notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'roundId')->textInput() ?>

    <?php echo $form->field($model, 'whoAmI')->textInput() ?>

    <?php echo $form->field($model, 'userId')->textInput() ?>

    <?php echo $form->field($model, 'notificationStatus')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
