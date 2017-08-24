<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model kaikaige\wxgz\models\WxLogGateway */

$this->title = 'Create Wx Log Gateway';
$this->params['breadcrumbs'][] = ['label' => 'Wx Log Gateways', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wx-log-gateway-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
