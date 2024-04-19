<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<!--<div style='text-align: center; background: url(img/Logos_Jadicc/header-JADIC2023.png) ; background-size:4780px;'>
    <div style="background:linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.9))">-->
<div style='text-align: center' >
    <div>
        
        <div class="row" >
            
        <div class="col-xs-2">
            <img  width="70%" src="img/50annosUNCo.png" alt="50 años"/></div>            
            <div class="col-xs-2">
            <img   src="img/faif150.png" alt="50 años"/></div>            
            <div class="col-xs-2">
            <img  src="img/Logos_Jadicc/logoSadosky.png" alt="sadosky"/></div>
            <div class="col-xs-4">
            <img   src="img/Logos_Jadicc/jadicc-2023.png" alt="jadicc"/></div>            
        
            
            

    </div>


        <h2 >Certificado</h2>
        <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->
     
        <h3>Se certifica que <b><?= mb_strtoupper($model->idPersona0->apellidoNombre, 'UTF-8'); ?></b>, DNI Nº <b><?= number_format($model->idPersona0->dni, 0, ',', '.') ?></b>
            ha participado en calidad de <b><?= strtolower($model->idLote0->idTipoCertificado0->tipo) ?></b>
            <!--            ha presentado el artículo-->
            <b><i><?= $model->observacion ?></i></b> en el <b><?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?></b>
            <b>"<?= $model->idLote0->idActividad0->nombre ?>"</b>. 
            <?= $model->idLote0->observacion ?></h3>

       <h3>Neuquén, <?= $model->idLote0->getFechaTexto(); ?>.</h3>

<!--        <div class="row">
                    <div class="col-xs-4" style="background-image:url('img/firmaazul.png');background-position: center; background-repeat: no-repeat; background-size: contain">
            <div class="col-xs-6" style="background-image: url('img/firmas/firmapesado.png'); background-repeat: no-repeat; background-size: 17% auto; background-position: top">
                <img src="img/firmas/firmagg.png" style="max-height: 100px" >
                <br/>
                <br/>
                <br/>
                <b>Lic. Patricia Pesado</b><br/>
                Coordinadora Titular<br/>
                Red UNCI
            </div>

            <div class="col-xs-5" style="background-image: url('img/firmas/firmagg.png'); background-repeat: no-repeat; background-size: 20% auto; background-position: top">
                <img src="img/firmas/firmagg.png" style="max-height: 100px" >
                <br/>
                <br/>
                <br/>
                <b>Lic. Guillermo Grosso</b><br/>
                Decano Facultad de Informática<br/>
                Universidad Nacional del Comahue
            </div>
        </div>-->

<!--
<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
        <img class="qr" src="<?= $qrCode->writeDataUri() ?>" >                        

    </div>

</div>



