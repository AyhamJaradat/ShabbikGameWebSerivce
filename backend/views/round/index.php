<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RoundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rounds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="round-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Create Round', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gameId',
            'roundNumber',
            'firstUserScore',
            'secondUserScore',
            // 'startDate',
            // 'gameConfiguration',
            // 'roundSentence',
            // 'isFinished',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
