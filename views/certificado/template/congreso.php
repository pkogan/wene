<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div style="text-align: center">

    <div class="row" >
<div class="col-xs-3">
    <img  width="50%" src="img/logoteyetcirculoblanco.png" alt="teyet"/>
                
            </div>

        <div class="col-xs-2">
        <img  src="img/logo-redunci.gif" alt="redUNCI"/>    
</div>
        
        <div class="col-xs-2">
            <img  width="80%" src="img/uncomarecortado.png" alt="UNCo"/></div>


    

        
        
        <div class="col-xs-3">
            <img  width="90%" src="img/faif.png" alt="Facultad de Informática"/></div>
    </div>

    <h1 >Certificado</h1>
    <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->




    <h3>Se certifica que <b><?= $model->idPersona0->apellidoNombre; ?></b>, DNI Nº <b><?= $model->idPersona0->dni; ?></b>
        <b><?= $model->idLote0->idTipoCertificado0->tipo ?></b> al <b><?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?></b>
        <b>"<?= $model->idLote0->idActividad0->nombre ?>"</b>. 
        <?= $model->idLote0->observacion ?></h3>

    <h3>Neuquén, <?= $model->idLote0->getFechaTexto(); ?>.</h3>
                
    <div class="row">
<!--        <div class="col-xs-4" style="background-image:url('img/firmaazul.png');background-position: center; background-repeat: no-repeat; background-size: contain">-->
<div class="col-xs-6" style="background-image: url('img/firmas/firmapesado.png'); background-repeat: no-repeat; background-size: 17% auto; background-position: top">
<!--    <img src="img/firmas/firmagg.png" style="max-height: 100px" >-->
             <br/>
             <br/>
<br/>
<b>Lic. Patricia Pesado</b><br/>
             Coordinadora Titular<br/>
             Red UNCI
        </div>
    
<div class="col-xs-5" style="background-image: url('img/firmas/firmagg.png'); background-repeat: no-repeat; background-size: 20% auto; background-position: top">
<!--    <img src="img/firmas/firmagg.png" style="max-height: 100px" >-->
             <br/>
             <br/>
<br/>
<b>Lic. Guillermo Grosso</b><br/>
             Decano Facultad de Informática<br/>
             Universidad Nacional del Comahue
        </div>
</div>


<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
<img class="qr" src="<?= $qrCode->writeDataUri() ?>" >                        


</div>



