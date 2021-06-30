<?php
/* @var $model \app\models\Certificado */
use yii\helpers\Html;
use yii\widgets\DetailView;
if(!is_null($model->idLote0->idActividad0->linkNorma)&&$model->idLote0->idActividad0->linkNorma!=''){
    $norma= Html::a($model->idLote0->idActividad0->norma,['norma', 'hash' => $model->hash]);
}else{
    $norma=$model->idLote0->idActividad0->norma;
}
echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idCertificado',
            'idPersona0.apellidoNombre',
            'idPersona0.dni',
            ['attribute'=>'idPersona0.legajo',
            'visible'=>$model->idPersona0->legajo!=''],
            ['label'=>'Condición Certificada','value'=>$model->idLote0->idTipoCertificado0->tipo],
            ['label'=>'Tipo Actividad','value'=>$model->idLote0->idActividad0->idTipoActividad0->tipo],
            ['label'=>'Nombre Actividad','value'=>$model->idLote0->idActividad0->nombre,
                'visible'=>$model->idLote0->idActividad0->nombre!=$model->idLote0->idTipoCertificado0->tipo],
            ['label'=>'Descripción Actividad','value'=>$model->idLote0->observacion,
                'visible'=>$model->idLote0->observacion!=''],
            ['label'=>'Dependencia Otorgante','value'=>$model->idLote0->idActividad0->idDependencia0->nombre],
            [//'attribute'=>'idLote0.idActividad0.norma',
             'label'=>'Norma','value'=>$norma, 'format'=>'raw',  
            'visible'=>$model->idLote0->idActividad0->norma!=''],
            ['label'=>'Fecha','value'=>$model->idLote0->idActividad0->getFechaTexto(),
                'visible'=>$model->idLote0->idTemplate!= \app\models\Template::ADJUNTO],
            ['label'=>'Duración','value'=>$model->idLote0->idActividad0->duracion.' '.$model->idLote0->idActividad0->medidaDuracion,
            'visible'=>$model->idLote0->idActividad0->duracion!=''],
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