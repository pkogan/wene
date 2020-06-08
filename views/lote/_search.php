<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lote-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idLote') ?>

    <?= $form->field($model, 'idActividad') ?>

    <?= $form->field($model, 'idEstado') ?>

    <?= $form->field($model, 'idTipoCertificado') ?>

    <?= $form->field($model, 'idTemplate') ?>

    <?php // echo $form->field($model, 'fechaEmision') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
