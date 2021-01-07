<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Round */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="round-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'gameId')->textInput() ?>

    <?php echo $form->field($model, 'roundNumber')->textInput() ?>

    <?php echo $form->field($model, 'firstUserScore')->textInput() ?>

    <?php echo $form->field($model, 'secondUserScore')->textInput() ?>

    <?php echo $form->field($model, 'startDate')->textInput() ?>

    <?php echo $form->field($model, 'gameConfiguration')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'roundSentence')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'isFinished')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
