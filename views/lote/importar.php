<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lote */
/* @var $provider yii\data\ArrayDataProvider*/

$this->title = 'Importar';
$actividad = $model->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label' => $actividad->idTipoActividad0->tipo . ': ' . $actividad->nombre,
    'url' => ['/actividad/view', 'id' => $actividad->idActividad]];
$this->params['breadcrumbs'][] = ['label' => 'Lote #' . $model->idLote,
    'url' => ['view', 'id' => $model->idLote]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lote-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($provider->count==0){?>
    <p>Solo se aceptan archivos .csv (Separados por comas) de al menos cuatro columnas, sin las cabeceras.  </p>
    <p>Columna 1 **(numérico)-> dni, Columna 2-> observación, Columna 3 *-> Apellido y Nombre, Columna 4 ->mail, Columna 5 -> legajo, Columna 6 **-> ID_Externo</p>
    <p>12345678,"","Parada Pepe","pepe@fi.uncoma.edu.ar","FAI-123","ID-53498"</p>
    <p>* Columnas Obligatorias</p>
    <p>** Los identificadores de la persona son DNI o ID_Externo.  En el caso de tener DNI la Columna 6 (ID_Extranjero) es opcional. En el caso de no contar con DNI hay que dejar la columna 1 (dni) sin datos y la columna 6 (ID__Externo) con datos como el ejermplo que sigue:</p>
    <p>,"","Parada Pepe","pepe@fi.uncoma.edu.ar","FAI-123","ID-53498"</p>
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelform, 'archivo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Importar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php } else{?>
    <h3>Resumen</h3>
    <div class="alert alert-success">
        
        <?php        foreach ($contadores as $contador=>$cantidad){
        echo '<h4  >'.$cantidad.' '.$contador.'</h4>';
    }?>
        </div>
<h3>Certificados Importados</h3>
    <?=
    yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'dni',
            'obs',
            'msj'],
    ]);
    ?>
    <?php }?>
</div>
