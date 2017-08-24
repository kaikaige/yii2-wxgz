<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model kaikaige\wxgz\models\WxLogGateway */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wx-log-gateway-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'get_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'return_xml')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
