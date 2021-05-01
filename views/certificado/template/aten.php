
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div style='text-align: center; background: url(img/fondocabeceraaten.png) no-repeat ; background-size: 100%'>
   <div style="background:linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.8))">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


<!--        <div class="row" >
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
        </div>-->

        <h1 >Certificado</h1>
        <!--        <h3>Facultad de Informática Universidad Nacional del Comahue</h3>-->




        <h3>Se certifica que <b><?= mb_strtoupper($model->idPersona0->apellidoNombre,'UTF-8'); ?></b> DNI Nº <b><?= number_format($model->idPersona0->dni,0,',','.'); ?></b>
            <b><?= strtolower($model->idLote0->idTipoCertificado0->tipo) ?></b> <?=$model->idLote0->idTipoCertificado0->conectorM;?> <b> <?= $model->idLote0->idActividad0->idTipoActividad0->tipo ?></b>
            <b>"<?= $model->idLote0->idActividad0->nombre ?>"</b>. 
            <?= $model->idLote0->observacion ?></h3>

        <h3>Neuquén, <?= $model->idLote0->getFechaTexto(); ?>.</h3>

        

<!--<p>
                Se puede validar el Certificado, accediendo al link del código QR, o a <a href="<?= \yii\helpers\Url::base('https') ?>"><?= \yii\helpers\Url::base('https') ?></a> con el código <b><?= $model->hash ?>
            </p>-->
        <img class="qr" src="<?= $qrCode->writeDataUri() ?>" > 

    </div>

</div>



