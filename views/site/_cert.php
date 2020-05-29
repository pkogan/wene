<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;
?>
<div class="cert-view">
<div id="logos_cert">
        <img class="logo" src="img/uncoma150.png" alt="UNCo"/>
        <img class="logo" src="img/sadosky.png" alt="Sadosky"/>
        <img class="logo" src="img/faif150.png" alt="Facultad de Informática"/>
   
</div>
    <h1><?= Html::encode($model['title']) ?></h1>

    <?php
    $qrCode = (new QrCode(\yii\helpers\Url::base('http') . '?r=site/demo&hash=' . $model['hash']))
            ->setSize(150)
            ->setMargin(5);
    //->useForegroundColor(51, 153, 255);
// now we can display the qrcode in many ways
// saving the result to a file:

    $qrCode->writeFile(__DIR__ . '/../../tmp/code.png'); // writer defaults to PNG when none is specified
// display directly to the browser 
    header('Content-Type: ' . $qrCode->getContentType());
//echo $qrCode->writeString();
    ?> 

    
    <h3>

        Trayecto Formativo aprobado por <a>Resolución XXX</a>
    </h3>
    <h3>Se certifica que <b>XXXXXXXXXXXXX</b>, DNI Nº <b>XXXXXXXX</b>
        <b>Aprobó</b> el curso de formación docente <b>La Programación y su Didáctica 2</b>
        dictado por docentes de la Facultad de Informática de la Universidad Nacional del Comahue
        en convenio con la Fundación Sadosky. Con una duración de <b>90 (noventa)</b> horas reloj de duración,
        desarrollado entre los meses de abril y agosto de 2019 en la ciuada de Zapala.</h3>

    <h3>Neuquén, 28 de mayo de 2020.</h3>

    <p>
        Accediendo al siguiente código QR se puede validar el certificado
    </p>
    <img class="qr" src="<?= $qrCode->writeDataUri() ?>">
    <?php /*    DetailView::widget([
      'model' => $model,
      'attributes' => [
      //'idEntrega',

      'fecha',
      ['label' => 'Maker', 'attribute' => 'producto.hacedor.apellidoNombre'],
      'ciudad.ciudad',
      ['label' => 'Institución', 'attribute' => 'institucion.nombre'],
      'receptor',
      ['label' => 'Modelo Nombre', 'attribute' => 'producto.modelo.nombre'],
      ['label' => 'Modelo Descripcion', 'attribute' => 'producto.modelo.descripcion'],
      'cantidad',
      'observacion',
      ['label' => 'QR', 'value' => $qrCode->writeDataUri(), 'format' => ['image', []]],
      'estado.estado'
      ],
      ])
     */ ?>

</div>

