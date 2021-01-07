<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Round */

$this->title = 'Update Round: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="round-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
