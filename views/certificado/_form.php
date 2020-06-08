<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificado-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= //$form->field($model, 'idPersona')->textInput() 
        $form->field($model, 'idPersona')->dropDownList(\app\models\Persona::find()
            ->select(['apellidoNombre'])
            ->orderBy('apellidoNombre')
            ->indexBy('idPersona')
            ->column())?>


    <?= //$form->field($model, 'idEstado')->textInput() 
        $form->field($model, 'idEstado')->dropDownList(\app\models\Estado::find()
            ->select(['estado'])
            ->indexBy('idEstado')
            ->column())?>

    <?php // $form->field($model, 'hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
