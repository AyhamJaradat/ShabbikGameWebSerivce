<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PullNotification */

$this->title = 'Update Pull Notification: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pull Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pull-notification-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
