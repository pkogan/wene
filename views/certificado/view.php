<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */

$this->title = 'Certificado #'.$model->idCertificado. ' '. $model->idPersona0->apellidoNombre;
$actividad=$model->idLote0->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label'=> $actividad->idTipoActividad0->tipo. ': '. $actividad->nombre,
    'url'=>['/actividad/view','id'=>$actividad->idActividad]];
$this->params['breadcrumbs'][] = ['label' => 'Lote #'.$model->idLote0->idLote, 'url' => ['/lote/view','id'=>$model->idLote0->idLote]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="certificado-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ver', ['ver', 'hash' => $model->hash], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->idCertificado], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('Delete', ['delete', 'id' => $model->idCertificado], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idCertificado',
            'idPersona',
            'idLote',
            'idEstado',
            'hash',
            'observacion',
        ],
    ]) ?>

</div>
