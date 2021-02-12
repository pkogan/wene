<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CertificadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificado-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //['label'=>'Dependencia','attribute'=>'dependencia','value'=>'idLote0.idActividad0.idDependencia0.nombre'],
            //'idLote0.fechaEmision:date',
            ['label' => 'Fecha Emisión', 'attribute' => 'dealerAvailableDate',
                'value' => 'idLote0.fechaTexto',
                //'format' => 'date',
                'filter' => kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dealerAvailableDate',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d'
                        ],
                    ],
                ]),
             ],
            ['label' => 'Dependencia Otorgante', 'attribute' => 'dependencia', 'value' => 'idLote0.idActividad0.idDependencia0.nombre'],
            ['label' => 'Apellido Nombre', 'attribute' => 'apellidoNombre', 'value' => 'idPersona0.apellidoNombre'],
            //['label' => 'mail', 'attribute' => 'mail', 'value' => 'idPersona0.mail'],
            ['label' => 'dni', 'attribute' => 'dni', 'value' => 'idPersona0.dni'],
            
            ['label'=> 'Tipo Cert', 'attribute'=>'idTipoCertificado','value'=>'idLote0.idTipoCertificado0.tipo',
                'filter' => //[
                    //yii\helpers\ArrayHelper::map(\app\models\TipoCertificado::find()->orderBy('tipo')->all(), 'idTipoCertificado', 'tipo')
                    
                \app\models\TipoCertificado::find()
            ->select(['tipo'])
            ->indexBy('idTipoCertificado')
            ->column()
                
                
            ],
            ['label'=>'Tipo','attribute'=>'idTipoActividad','value'=>'idLote0.idActividad0.idTipoActividad0.tipo',
                 'filter' => \app\models\TipoActividad::find()
            ->select(['tipo'])
            ->indexBy('idTipo')
            ->column()
                ],
            ['label'=>'Actividad','attribute'=>'actividad','value'=>'idLote0.idActividad0.nombre'],
            
            
            /*    ['attribute' => 'idEstado',
                'label' => 'Estado',
                'value'=>'idEstado0.estado',
                'filter' => [
                    \app\models\Estado::ESTADO_INICIAL => 'Inicial',
                    \app\models\Estado::ESTADO_EMITIDO => 'Emitido',
                    \app\models\Estado::ESTADO_ENVIADO => 'Enviado',
                    \app\models\Estado::ESTADO_RECIBIDO => 'Recibido'
                ]],*/
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} ',
                'urlCreator' => function( $action, $model, $key, $index ) {

                    if ($action == "view") {
                        return \yii\helpers\Url::to(['/certificado/view', 'hash' => $model->hash]);
                    }

                }],
        ],
    ]);?>

    <?php Pjax::end(); ?>

</div>
