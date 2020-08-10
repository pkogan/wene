<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dni')->textInput() ?>

    <?= $form->field($model, 'apellidoNombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'legajo')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'Comentario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idCiudad')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
