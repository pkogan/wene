<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div style='text-align: center;'>
<!--<div style='text-align: center; background: url(img/FALE/FALEguarda.jpeg) no-repeat; background-size: 100% 200px; background-position: bottom left; '>
<div style='background: linear-gradient(circle, rgba(255,255,255,0.1), rgba(255,255,255,0.9))'> -->
<div class="row" style="padding-top: 50px" >

    <div class="col-xs-3">
            <img  width="60%" src="img/FALE/logoSAEL.jpeg" alt="SAEL"/></div>

  <div class="col-xs-4">
  
  <img   width="50%" src="img/uncomarecortado.png" alt="UNCo"/></div>
  

        <div class="col-xs-3">
            <img  width="60%" src="img/FALE/logo fadel.png" alt="Facultad de Lenguas"/></div>

    </div>

    <h1 >Certificado</h1>
    <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->




    <h3>Se certifica que <b><?= mb_strtoupper($model->idPersona0->apellidoNombre,'UTF-8'); ?></b>, DNI Nº <b><?= number_format($model->idPersona0->dni,0,',','.'); ?></b><br/>
        <b><?= $model->idLote0->idTipoCertificado0->tipo ?></b> al <b><?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?></b>
        
        <b><?= $model->idLote0->idActividad0->nombre ?></b><!--, el <?= $model->idLote0->idActividad0->getFechaTexto(); ?>.-->
        <!--y con una duración de <?= $model->idLote0->idActividad0->duracion ?> <?= $model->idLote0->idActividad0->medidaDuracion ?>.-->
        <?= ($model->idLote0->idActividad0->norma!='')?'Avalado por '.$model->idLote0->idActividad0->norma.'. ':''?>
        <?= $model->idLote0->observacion ?></h3>

    <h3 >Neuquén, <?= $model->idLote0->getFechaTexto(); ?>.</h3>

 <!--          <div class="row" style="font-size: 11px;">
            <div class="col-xs-3" style="background-image: url('img/firmas/firmalidia.png'); background-repeat: no-repeat; background-size: 35% auto; background-position: top">
                <br/>
                <br/>
                <br/>
                <b>Mg. Lidia Marina López</b><br/>
                Secretaría Académica<br/>
                Universidad Nacional del Comahue
            </div>

            <div class="col-xs-4" style="background-image: url('img/firmas/firmacarina.png'); background-repeat: no-repeat; background-size: 20% auto; background-position: top">
                <br/>
                <br/>
                <br/>
                    <b>Dra. Carina Fracchia</b><br/>
                Cordinadora de la Maestría<br/>
                Enseñanza en Escenarios Digitales<br/>
                Facultad de Informática - UNComahue
            </div>

            <div class="col-xs-3" style="background-image: url('img/firmas/firmapk.png'); background-repeat: no-repeat; background-size: 25% auto; background-position: top">
                <br/>
                <br/>
                <br/>
                <b>Lic. Pablo Kogan</b><br/>
                Secretario de Extensión<br/>
                Facultad de Informática - UNComahue
            </div>
        </div>
-->
    <div class="row" style="padding-top: 20px; ">
<!--        <div class="col-xs-4" style="background-image:url('img/firmaazul.png');background-position: center; background-repeat: no-repeat; background-size: contain">-->


<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
<img class="qr" src="<?= $qrCode->writeDataUri() ?>" >                        

    </div>
<!--    <div class="row"  style="padding-top: 20px; height: 200px">
    <div class="col-xs-12">
            <img   src="img/FALE/FALEguarda.jpeg" alt="Facultad de Lenguas"/></div>

    </div>
</div> -->
<!--<br/>
<br/><br/><br/>

</div> -->
</div>


