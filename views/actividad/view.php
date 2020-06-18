<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

$this->title = $model->idTipoActividad0->tipo . ': ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="actividad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == app\models\Rol::ROL_GESTOR) {
            echo Html::a('Crear Lote', ['/lote/create', 'id' => $model->idActividad], ['class' => 'btn btn-success']);
            echo Html::a('Update', ['update', 'id' => $model->idActividad], ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->idActividad], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idActividad',
            'idTipoActividad0.tipo',
            'idDependencia0.nombre',
            'idActividadPadre',
            'nombre',
            'descripcion:ntext',
            'fecha',
            'norma',
            'idCiudad0.ciudad',
            'duracion',
            'medidaDuracion',
            'observaciones:ntext',
        ],
    ])
    ?>
    <h2>Lotes de Certificados</h2>
    <?php
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == app\models\Rol::ROL_GESTOR) {
        echo Html::a('Crear Lote', ['/lote/create', 'id' => $model->idActividad], ['class' => 'btn btn-success']);
    }
    ?>
    <?=
    yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'idLote',
            //'idActividad',
            'fechaEmision:date',
            'idEstado0.estado',
            'idTipoCertificado0.tipo',
            //'idTemplate',
            //'observacion:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'urlCreator' => function( $action, $model, $key, $index ) {
                    if ($action == "view") {
                        return \yii\helpers\Url::to(['/lote/view', 'id' => $key]);
                    }
                }],
        ],
    ]);
    ?>

</div>
