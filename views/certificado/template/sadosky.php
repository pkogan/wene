<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */
?>
<div class="cert-view">
<div id="logos_cert">
        <img class="logo" src="img/uncoma150.png" alt="UNCo"/>
        <img class="logo" src="img/sadosky.png" alt="Sadosky"/>
        <img class="logo" src="img/faif150.png" alt="Facultad de Informática"/>
   
</div>
    <h1><?= Html::encode('Certificado') ?></h1>

    <h3>

        Trayecto Formativo aprobado por <a>Resolución XXX</a>
    </h3>
    <h3>Se certifica que <b><?= $model->idPersona0->apellidoNombre;?></b>, DNI Nº <b><?= $model->idPersona0->dni;?></b>
        <b><?= $model->idLote0->idTipoCertificado0->tipo?></b> el <b><?= $model->idLote0->idActividad0->idTipoActividad0->tipo?></b>
        <b>"<?= $model->idLote0->idActividad0->nombre?>"</b>, el <?= $model->idLote0->idActividad0->getFechaTexto();?>
         y con una duración de <?=$model->idLote0->idActividad0->duracion?> horas.
         <?=$model->idLote0->observacion?></h3>

    <h3>Neuquén, <?=$model->idLote0->fechaEmision;?>.</h3>

    <p>
        Accediendo al siguiente código QR se puede validar el certificado.  Si no se cuenta con lector de códigos QR el certificado se puede validar entrando a <a href="<?=\yii\helpers\Url::base('https') ?>"><?=\yii\helpers\Url::base('https') ?></a> con el código <b><?=$model->hash?>
    </p>
    <img class="qr" src="<?= $qrCode->writeDataUri() ?>">


</div>



