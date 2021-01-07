<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Game */

$this->title = 'Update Game: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
