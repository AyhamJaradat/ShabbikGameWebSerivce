<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Game */

$this->title = 'Create Game';
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
