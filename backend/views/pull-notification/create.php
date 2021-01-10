<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PullNotification */

$this->title = 'Create Pull Notification';
$this->params['breadcrumbs'][] = ['label' => 'Pull Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pull-notification-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
