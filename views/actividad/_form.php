<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $options = [
        'options' => ['id' => 'idCiudad', 'placeholder' => 'Seleccionar ...'],
        'id' => 'idCuidad',
        'pluginOptions' => [
            'depends' => ['idProvincia'],
            'url' => \yii\helpers\Url::to(['/ciudad/combo'])
    ]];

    if (!is_null($model->idCiudad)) {
        $model->idProvincia = $model->idCiudad0->idProvincia;
        $options['data'] = yii\helpers\ArrayHelper::map(\app\models\Ciudad::find()->where("idProvincia in ($model->idProvincia) and categoria<>".'"ENTIDAD"')->orderBy('ciudad')->all(), 'idCiudad', 'ciudad');

    }
    ?>


<div class="actividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= //$form->field($model, 'idTipoActividad')->textInput()
    $form->field($model, 'idTipoActividad')->dropDownList(\app\models\TipoActividad::find()
            ->select(['tipo'])
            ->indexBy('idTipo')
            ->column())?>

    <?= //$form->field($model, 'idDependencia')->textInput()
            $form->field($model, 'idDependencia')->dropDownList(\app\models\Dependencia::find()
            ->joinWith('usuarioDependencias')->where(['idUsuario'=> \Yii::$app->user->identity->idUsuario])
            ->select(['nombre'])
            ->indexBy('idDependecia')
            ->column())?>

    <?= $form->field($model, 'idActividadPadre')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= //$form->field($model, 'fecha')->textInput() 
        $form->field($model, 'fecha')
         ->widget(
                 kartik\date\DatePicker::className(),
             [
                 'options' => ['placeholder' => 'fecha'],
                 //'convertFormat' => true,
                 'pluginOptions' => [
                     'format' => 'yyyy-mm-dd',
                 ],
         ])
  ?>
  <?= $form->field($model, 'duracion')->textInput() ?>
  <?= $form->field($model, 'medidaDuracion')->textInput() ?>
    <?= $form->field($model, 'norma')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'idProvincia')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Provincia::find()->orderBy('provincia')->all(), 'idProvincia', 'provincia'), ['id' => 'idProvincia', 'prompt' => 'Seleccionar ...'])
    ?>

    <?= //$form->field($model, 'idCiudad')->textInput() 
            $form->field($model, 'idCiudad')->widget(\kartik\depdrop\DepDrop::classname(), $options)?>

    

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
