<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lote */


$v = 'Lote #' . $model->idLote;
$this->title = 'Actualizar '.$v;
$actividad = $model->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label' => $actividad->idTipoActividad0->tipo . ': ' . $actividad->nombre,
    'url' => ['/actividad/view', 'id' => $actividad->idActividad]];
$this->params['breadcrumbs'][] = ['label' => $v, 'url' => ['view', 'id' => $model->idLote]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="lote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actividad'=>$actividad,
    ]) ?>

</div>
