<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateDependencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-dependencia-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'idTemplate')->dropDownList(\app\models\Template::find()
            ->select(['template'])
            ->indexBy('idTemplate')
            ->column())?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
