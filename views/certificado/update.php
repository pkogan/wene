<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */

$v = 'Certificado #'.$model->hash. ' '. $model->idPersona0->apellidoNombre;

$actividad=$model->idLote0->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label'=> $actividad->idTipoActividad0->tipo. ': '. $actividad->nombre,
    'url'=>['/actividad/view','id'=>$actividad->idActividad]];
$this->params['breadcrumbs'][] = ['label' => 'Lote #'.$model->idLote0->idLote, 'url' => ['/lote/view','id'=>$model->idLote0->idLote]];
$this->params['breadcrumbs'][] = ['label' => $v, 'url' => ['view', 'hash' => $model->hash]];
$this->params['breadcrumbs'][] = 'Actualizar';



$this->title = 'Actualizar ' . $v;

?>
<div class="certificado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
