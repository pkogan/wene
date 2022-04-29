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
            <img  src="img/uncoma.png" height="170px" alt="UNCo"/></div>
        <div class="col-xs-4">
        <img class="logo" src="img/FLISOLAR.jpg" alt="FLISoL"/>
        </div>

        <div class="col-xs-3">
            <img  src="img/faif.png" height="150px" alt="Facultad de Informática"/></div>
    </div>

    <h1 >Certificado</h1>
    <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->




    <h3>Se certifica que <b><?= $model->idPersona0->apellidoNombre; ?></b> <?=$model->idPersona0->getDnioIdExt()?><br/>
        <b><?= $model->idLote0->idTipoCertificado0->tipo ?></b> <?=$model->idLote0->getConector() ?> <b><?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?></b>
        <b><?= $model->idLote0->idActividad0->nombre ?></b>, el <?= $model->idLote0->idActividad0->getFechaTexto(); ?>.<br/>
        <!--y con una duración de <?= $model->idLote0->idActividad0->duracion ?> <?= $model->idLote0->idActividad0->medidaDuracion ?>.-->
        <?= ($model->idLote0->idActividad0->norma!='')?'Avalado por '.$model->idLote0->idActividad0->norma.'. ':''?>
        <?= $model->idLote0->idActividad0->observaciones ?></h3>

    <h3 >Neuquén, <?= $model->idLote0->getFechaTexto(); ?>.</h3>
                
    <div class="row" style="padding-top: 50px">
<!--        <div class="col-xs-4" style="background-image:url('img/firmaazul.png');background-position: center; background-repeat: no-repeat; background-size: contain">-->


<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
<img class="qr" src="<?= $qrCode->writeDataUri() ?>" >                        

    </div>


</div>



