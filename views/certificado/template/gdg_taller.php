<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div style="text-align: center">
<!--<div style='text-align: center; background: url(img/logoteyetcirculoblanco.png) ; background-size: auto'>-->
<!--    <div style="background:linear-gradient(rgba(255,255,255,.9), rgba(255,255,255,.8))">-->

  <div class="row" >

 <div class="col-xs-4">
            <img   width="40%" src="img/uncomarecortado.png" alt="UNCo"/></div>
        <div class="col-xs-3">
            <img   src="img/gdg.png" alt="Sadosky"/></div>


        <div class="col-xs-3">
            <img  width="90%" src="img/faif.png" alt="Facultad de Informática"/></div>

    </div>

    <h1 >Certificado</h1>

<!--                <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->




        <h3>Se certifica que <b><?= mb_strtoupper($model->idPersona0->apellidoNombre); ?></b>, DNI Nº <b><?= number_format($model->idPersona0->dni,0,',','.') ?></b>
            <b><?= strtolower($model->idLote0->idTipoCertificado0->tipo) ?></b> <?=$model->idLote0->getConector() ?> <?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?>
<!--            ha presentado el artículo-->
            <b><i><?=$model->observacion?></i></b> en el marco del </b>
            <b>"<?= $model->idLote0->idActividad0->nombre ?>"</b>. 
            <?= ($model->idLote0->idActividad0->norma!='')?'Avalado por '.$model->idLote0->idActividad0->norma.'. ':''?>
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


<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
        <img class="qr" src="<?= $qrCode->writeDataUri() ?>" >                        

    <!--</div>-->

</div>



