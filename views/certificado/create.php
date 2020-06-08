<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */

$this->title = 'Create Certificado';
$actividad=$lote->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label'=> $actividad->idTipoActividad0->tipo. ': '. $actividad->nombre,
    'url'=>['/actividad/view','id'=>$actividad->idActividad]];

$this->params['breadcrumbs'][] = ['label' => 'Lote #'.$lote->idLote, 'url' => ['/lote/view','id'=>$lote->idLote]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
