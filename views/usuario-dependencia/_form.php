<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioDependencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-dependencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'idDependencia')->dropDownList(\app\models\Dependencia::find()
            ->select(['nombre'])
            ->indexBy('idDependecia')
            ->column())?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
