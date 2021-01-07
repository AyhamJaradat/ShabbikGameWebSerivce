<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RoundSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="round-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'gameId') ?>

    <?php echo $form->field($model, 'roundNumber') ?>

    <?php echo $form->field($model, 'firstUserScore') ?>

    <?php echo $form->field($model, 'secondUserScore') ?>

    <?php // echo $form->field($model, 'startDate') ?>

    <?php // echo $form->field($model, 'gameConfiguration') ?>

    <?php // echo $form->field($model, 'roundSentence') ?>

    <?php // echo $form->field($model, 'isFinished') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
