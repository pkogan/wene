<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CertificadoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificado-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idCertificado') ?>

    <?= $form->field($model, 'idPersona') ?>

    <?= $form->field($model, 'idLote') ?>

    <?= $form->field($model, 'idEstado') ?>

    <?= $form->field($model, 'hash') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
