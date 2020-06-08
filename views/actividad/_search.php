<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActividadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idActividad') ?>

    <?= $form->field($model, 'idTipoActividad') ?>

    <?= $form->field($model, 'idDependencia') ?>

    <?= $form->field($model, 'idActividadPadre') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'norma') ?>

    <?php // echo $form->field($model, 'idCiudad') ?>

    <?php // echo $form->field($model, 'duracion') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
