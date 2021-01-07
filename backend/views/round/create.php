<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Round */

$this->title = 'Create Round';
$this->params['breadcrumbs'][] = ['label' => 'Rounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="round-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
