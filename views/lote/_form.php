<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lote */
/* @var $actividad app\models\Actividad*/
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lote-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'idActividad')->textInput() ?>-->

    <?= //$form->field($model, 'idEstado')->textInput() 
             $form->field($model, 'idEstado')->dropDownList(\app\models\Estado::find()
            ->select(['estado'])
            ->indexBy('idEstado')
            ->column())?>

    <?= //$form->field($model, 'idTipoCertificado')->textInput() 
             $form->field($model, 'idTipoCertificado')->dropDownList(\app\models\TipoCertificado::find()
            ->select(['tipo'])
            ->indexBy('idTipoCertificado')
            ->column())?>

    <?php //$form->field($model, 'idTemplate')->textInput()
            echo $form->field($model, 'idTemplate')->dropDownList(\app\models\Template::find()
            ->joinWith('templateDependencias')->where(['idDependencia'=> $actividad->idDependencia ])
            ->select(['template'])
            ->indexBy('idTemplate')
            ->column())

/*            $form->field($model, 'idTemplate')->dropDownList(\app\models\Template::find()
            ->select(['template'])
            ->indexBy('idTemplate')
            ->column())?>*/
            ?>

    <?= //$form->field($model, 'fechaEmision')->textInput() 
            $form->field($model, 'fechaEmision')
         ->widget(
                 kartik\date\DatePicker::className(),
             [
                 'options' => ['placeholder' => 'fechaEmision'],
                 //'convertFormat' => true,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                 ],
         ])?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
