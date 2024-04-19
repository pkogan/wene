<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombreUsuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idRol')->dropDownList(\app\models\Rol::find()
            ->select(['nombre'])
            ->indexBy('idRol')
            ->column())?>

    <?php if (isset($is_create) && $is_create): ?>
        <?= $form->field($model, 'clave')->textInput(['maxlength' => true, 'value' => '']) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
