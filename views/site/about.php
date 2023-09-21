<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Acerca de';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Sistema desarrollado por la Facultad de Informática de la Universidad Nacional del Comahue.
        Bajo licencia GNU GPL.  
    </p>

    <code>Fuentes disponibles en <a href="https://github.com/pkogan/wene">https://github.com/pkogan/wene</a></code>


        <div class="row">
            <div class="col-lg-4">
                <h2>Certificados Digitales</h2>

                <p>Con el objetivo de agilizar los procesos, hacer un aporte al medio ambiente y ahorrar papel, todas las actividades realizadas por la Facultad de Informática tendrán solamente certificados digitales</p>
                <p> <a class="btn btn-default" href="<?= \yii\helpers\Url::base('https') ?>/img/ResCD-031-Ratificar-ResAdRef077-Certificados-Digitales-EXTescopia.pdf">ResCD Nro 031/20 &raquo;</a>
                    <a class="btn btn-default" href="<?= \yii\helpers\Url::base('https') ?>/img/ResCD-064-Ratificar-ResAdRef117-Certificados-Digitales-Academica-SAescopia.pdf">ResCD Nro 064/20 &raquo;</a>
                  
                </p>
                
                
                <h2>Registro histórico de Actividades</h2>

                <p> Lxs titulares que han recibido certificados por mail, puenden acceder a su historial de actividades/certificados emitidos por las Organizaciones que utilizan el sistema</p>
                <p> <?= yii\helpers\Html::a('Buscar mis Certificados &raquo;', ['/certificado/mis'], ['class' => 'btn btn-default']) ?>
                    
                    
                </p>
    <!--                <p><a class="btn btn-default" href="">Resolución XXX/20 &raquo;</a></p>-->
            </div>
            <div class="col-lg-4">
                <h2>Validación por codigo QR</h2>

                <p>Teniendo una copia digital se puede acceder mediante la lectura de código QR o mediante un código del certificado,
                    utilizando como fuente auténtica el subdominio de la Facultad de Informática https://wene.fi.uncoma.edu.ar. El subdominio
                    tiene certificación ssl.</p>

                <p><?= \yii\helpers\Html::a('Ver demo &raquo;', ['/certificado/view', 'hash' => 'ab514d', 'pdf' => 'true'], ['class' => 'btn btn-default']); ?>
                    <!--                    <a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>-->
            </div>
            <div class="col-lg-4">
                <h2>Válidos en CPE Neuquén</h2>

                <p>RESOLUCIÓN N°1135 / EXPEDIENTE N°8120-003418/2019 12/9/2019</p>

                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::base('http') ?>/img/r_1135_19.pdf">Resolución CPE 1135/19 &raquo;</a></p>
                <h2>Convenios con otras Organizaciones</h2>
                <p>Se ha realizado convenio para emisión de certificados con Secretaría de extensión de la Facultad de Humanidades <a class="btn btn-default" href="<?= \yii\helpers\Url::base('https') ?>/img/0076_20_AvalCertificadoVirtualExtension.pdf">ResCD FH Nro 076/20 &raquo;</a>
                    , con Sub-Secretaría de Relaciones Internacionales  <a class="btn btn-default" href="<?= \yii\helpers\Url::base('https') ?>/img/ACTA ACUERDO FI SRRII firmado.pdf">Disp SRRII Nro 003/21 &raquo;</a>
                   y con la Asociación de Trabajadores de Educación de Neuquen (aten) <a class="btn btn-default" href="<?= \yii\helpers\Url::base('https') ?>/img/convenioatenwene.pdf">Convenio aten-FAIF &raquo;</a></p>
            </div>
        </div>
</div>
