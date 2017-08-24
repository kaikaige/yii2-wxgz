<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model kaikaige\wxgz\models\WxLogGateway */

$this->title = 'Update Wx Log Gateway: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wx Log Gateways', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wx-log-gateway-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
