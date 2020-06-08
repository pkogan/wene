<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\CertForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>
    <?php $form = ActiveForm::begin([
        'id' => 'cert-form',
        'action'=> yii\helpers\Url::to(['certificado/view']),
        'method'=> 'get'
        ]
    ); ?>
    
        <?=  $form->field($model, 'hash')->textInput(['name'=>'hash']) ?>
        <?= Html::submitButton('Validar', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

