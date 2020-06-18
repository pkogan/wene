<?php
/* @var $model \app\models\Certificado */
use yii\helpers\Html;
use yii\widgets\DetailView;
echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idCertificado',
            'idPersona0.apellidoNombre',
            'idPersona0.dni',
            ['label'=>'Condición Certificada','value'=>$model->idLote0->idTipoCertificado0->tipo],
            ['label'=>'Tipo Actividad','value'=>$model->idLote0->idActividad0->idTipoActividad0->tipo],
            ['label'=>'Nombre Actividad','value'=>$model->idLote0->idActividad0->nombre],
            ['label'=>'Descripción Actividad','value'=>$model->idLote0->idActividad0->observaciones],
            ['label'=>'Dependencia Otorgante','value'=>$model->idLote0->idActividad0->idDependencia0->nombre],
            'idLote0.idActividad0.norma',
            ['label'=>'Fecha','value'=>$model->idLote0->idActividad0->getFechaTexto()],
            ['label'=>'Duración','value'=>$model->idLote0->idActividad0->duracion.' '.$model->idLote0->idActividad0->medidaDuracion],
            //'idLote0.observacion',
            
            ['label'=>'Validar','value'=>'Accediendo al siguiente código QR se puede validar el certificado. '.
                'Si no tienen lector de códigos QR el certificado se puede validar entrando a '.\yii\helpers\Url::base('https').' con el código '.$model->hash],
                 //'<a href="'.\yii\helpers\Url::base('https').'">'.\yii\helpers\Url::base('https').'</a> con el código <b>'.$model->hash.'</b>'],
            ['label' => 'QR', 'value' => $qrCode->writeDataUri(), 'format' => ['image', []]],
            //'idEstado0.estado',
            ['label'=>'Código del Certificado','value'=>$model->hash],
            ['label'=>'Fecha Emisión','value'=>$model->idLote0->getFechaTexto()],
            ['label'=>'Estado Certificado','value'=>$model->idEstado0->estado]
            
            
        ],
    ]); 