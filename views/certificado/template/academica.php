<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div style="text-align: center">
    <br>
    <br>
    <div class="row" >

        <div class="col-xs-5">
            <img  width="40%" src="img/uncomarecortado.png" alt="UNCo"/></div>
<!--        <img class="logo" src="img/sadosky.png" alt="Sadosky"/>-->

        <div class="col-xs-5">
            <img  width="65%" src="img/faif.png" alt="Facultad de Informática"/></div>
    </div>

    <h1 >Certificado Digital</h1>
    <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idCertificado',
            ['label'=>'Condición Certificada','value'=>$model->idLote0->idTipoCertificado0->tipo],
            'idPersona0.apellidoNombre',
            'idPersona0.dni',
            
            ['attribute'=>'idPersona0.legajo',
            'visible'=>$model->idPersona0->legajo!=''],
                
            ['label'=>'Detalles','value'=>$model->idLote0->observacion],
            //['label'=>'Descripción Actividad','value'=>$model->idLote0->idActividad0->observaciones],
            ['label'=>'Dependencia Otorgante','value'=>$model->idLote0->idActividad0->idDependencia0->nombre],
            ['attribute'=>'idLote0.idActividad0.norma',
            'visible'=>$model->idLote0->idActividad0->norma!=''],
            ['label'=>'Fecha Emisión','value'=>$model->idLote0->getFechaTexto()],
            //'idLote0.idActividad0.norma',
            //['label'=>'Fecha','value'=>$model->idLote0->idActividad0->getFechaTexto()],
            //['label'=>'Duración','value'=>$model->idLote0->idActividad0->duracion.' '.$model->idLote0->idActividad0->medidaDuracion],
            //'idLote0.observacion',
            ['label'=>'Código del Certificado','value'=>$model->hash],
            ['label'=>'Validar','value'=>'Accediendo al siguiente código QR se puede validar el certificado. '.
                'Si no posee lector de códigos QR el certificado se puede validar entrando a '.\yii\helpers\Url::base('https').' con el código '.$model->hash],
                 //'<a href="'.\yii\helpers\Url::base('https').'">'.\yii\helpers\Url::base('https').'</a> con el código <b>'.$model->hash.'</b>'],
            ['label' => 'QR', 'value' => $qrCode->writeDataUri(), 'format' => ['image', []]],
            //'idEstado0.estado',
            
            
            //['label'=>'Estado Certificado','value'=>$model->idEstado0->estado]
            
            
        ],
    ]); 
    ?>

</div>



