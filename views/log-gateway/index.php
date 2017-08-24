<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel kaikaige\wxgz\models\searches\WxLogGateway */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wx Log Gateways';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wx-log-gateway-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wx Log Gateway', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'get_data:ntext',
            'post_data:ntext',
            'return_xml:ntext',
            // 'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
