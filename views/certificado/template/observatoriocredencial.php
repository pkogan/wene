<?php
/* @var $model \app\models\Certificado */
use yii\helpers\Html;
use yii\widgets\DetailView;
if(!is_null($model->idLote0->idActividad0->linkNorma)&&$model->idLote0->idActividad0->linkNorma!=''){
    $norma= Html::a($model->idLote0->idActividad0->norma,['norma', 'hash' => $model->hash]);
}else{
    $norma=$model->idLote0->idActividad0->norma;
}?>
<div style="text-align: center">
    <div class="row" style="padding-top: 5px">

<!--        <div class="col-xs-5">
            <img  width="40%" src="img/uncomarecortado.png" alt="UNCo"/></div>-->
<!--        <img class="logo" src="img/sadosky.png" alt="Sadosky"/>-->

        <div class="col-xs-12">
                <img  width="70%" src="img/OEUNCo.png" alt="Observatorio"/></div>
    </div>

    <h4 >Certificado Digital</h4>
<!--    <hr/>-->
<!--    <h4>Apellido y Nombre</h4>-->
<h4> <b><?= mb_strtoupper($model->idPersona0->apellidoNombre,'UTF-8'); ?></b><br/>
    
    
    <b><?= $model->idPersona0->getDnioIdext();//number_format($model->idPersona0->dni,0,',','.'); ?></b></h4>
<!--    <h4>DNI</h4>-->
<!--    <hr/>-->
<!--    <br/>-->
<!--            <h4>Cumple el Rol de</h4>-->
            <h4>        
        <b><?= $model->idLote0->idTipoCertificado0->tipo ?></b> <br/>
        
        <b><?= mb_strtoupper($model->idLote0->idActividad0->nombre) ?></b><br/>
            <?= $model->idLote0->getFechaTexto(); ?></h4>
            
     
<!--        <h3><?= $model->idLote0->observacion ?></h3>-->
    
<!--<hr/>-->
    
                
    <div class="row" style="padding-top: 5px">
<!--        <div class="col-xs-4" style="background-image:url('img/firmaazul.png');background-position: center; background-repeat: no-repeat; background-size: contain">-->


<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
<img width="100px"      src="<?= $qrCode->writeDataUri() ?>" >                        

    </div>

<?php  DetailView::widget([
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
            ['label'=>'Nota','value'=>$model->observacion,
                'visible'=>$model->observacion!=''],
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
    ?>

</div>