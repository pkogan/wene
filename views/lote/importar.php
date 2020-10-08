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
    <p>Solo se aceptan archivos .csv de dos columnas, sin las cabeceras.  Columna 1 -> dni, Columna 2 -> observación</p>
    <p>Opcionales se pueden agregar las columnas Columna 3 -> Apellido y Nombre, Columna 4 ->mail, Columna 5 -> legajo en el caso de importar Personas Nuevas</p>
    <p>12345678,"","Parada Pepe","pepe@fi.uncoma.edu.ar","FAI-123"</p>
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
