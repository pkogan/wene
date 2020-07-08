<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lote */

$this->title = 'Lote #' . $model->idLote;
$actividad = $model->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label' => $actividad->idTipoActividad0->tipo . ': ' . $actividad->nombre,
    'url' => ['/actividad/view', 'id' => $actividad->idActividad]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == app\models\Rol::ROL_GESTOR) {
            echo Html::a('Importar', ['importar', 'id' => $model->idLote], ['class' => 'btn btn-success']);
            echo ' '.Html::a('Comunicar', ['/certificado/maillote', 'id' => $model->idLote], ['class' => 'btn btn-primary',
                'data' => ['confirm' => 'Está seguro de enviar mail a ' . count($model->certificados) . ' personas del lote?']
            ]);
            echo ' '.Html::a('Actualizar', ['update', 'id' => $model->idLote], ['class' => 'btn btn-primary']);
            echo ' '.Html::a('Borrar', ['delete', 'id' => $model->idLote], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Está seguro de borrar el Lote?',
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
            //'idLote',
            'idActividad0.nombre',
            'idEstado0.estado',
            'idTipoCertificado0.tipo',
            'idTemplate0.template',
            'fechaEmision:date',
            'observacion:ntext',
        ],
    ])
    ?>
    <h2>Certificados del Lote</h2>
    <?php
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol == app\models\Rol::ROL_GESTOR) {
        echo Html::a('Crear Certificado', ['/certificado/create', 'id' => $model->idLote], ['class' => 'btn btn-success']);
    }
    ?>
    <?=
    yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            //'idLote',
            //'idActividad',
            //'fechaEmision:date',
            ['label' => 'Apellido Nombre', 'attribute' => 'apellidoNombre', 'value' => 'idPersona0.apellidoNombre'],
            ['label' => 'mail', 'attribute' => 'mail', 'value' => 'idPersona0.mail'],
            ['label' => 'dni', 'attribute' => 'dni', 'value' => 'idPersona0.dni'],
            
                ['attribute' => 'idEstado',
                'label' => 'Estado',
                'value'=>'idEstado0.estado',
                'filter' => [
                    \app\models\Estado::ESTADO_INICIAL => 'Inicial',
                    \app\models\Estado::ESTADO_EMITIDO => 'Emitido',
                    \app\models\Estado::ESTADO_ENVIADO => 'Enviado',
                    \app\models\Estado::ESTADO_RECIBIDO => 'Recibido'
                ]],
            //'idTipoCertificado0.tipo',
            //'idTemplate',
            //'observacion:ntext',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {download} {mail}',
                'buttons' => [
                    'download' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-download"></span>', $url, [
                                    'title' => Yii::t('yii', 'Descargar'),
                        ]);
                    },
                    'mail' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-send"></span>', $url, [
                                    'title' => Yii::t('yii', 'Enviar Mail'),
                                    'data' => [
                                        'confirm' => 'Está seguro de envíar mail a ' . $model->idPersona0->mail,
                                    //'method' => 'post',
                                    ],
                        ]);
                    }
                ],
                'urlCreator' => function( $action, $model, $key, $index ) {
                    /* if ($action == "update") {
                      return \yii\helpers\Url::to(['/certificado/view', 'id' => $key]);
                      } */
                    if ($action == "view") {
                        return \yii\helpers\Url::to(['/certificado/view', 'hash' => $model->hash]);
                    }
                    if ($action == "download") {
                        return \yii\helpers\Url::to(['/certificado/view', 'hash' => $model->hash, 'pdf' => true]);
                    }
                    if ($action == "mail") {
                        return \yii\helpers\Url::to(['/certificado/mail', 'hash' => $model->hash]);
                    }
                }],
        ],
    ]);
    ?>


</div>
