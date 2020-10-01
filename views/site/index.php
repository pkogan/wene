<?php

/* @var $this yii\web\View */

$this->title = 'wene - Certificados Facultad de Informática';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><img height="75px" src="img/logolargonegro.png"> - Certificados</h1>

        <p class="lead">Sistema de Certificados de las Actividades realizadas por la Facultad de Informática de la Universidad Nacional del Comahue</p>
 <p> <?=$this->render('_formcert',['model'=>$model])?>
       <?php //echo \yii\helpers\Html::a('Ver demo', ['/site/demo', 'hash' => substr(md5('demo'),0,7),'pdf'=>'true'], ['class' => 'btn btn-lg btn-success']);?>
            
<!--            <a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Ver Demo</a>-->
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Certificados Digitales</h2>

                <p>Con el objetivo de agilizar los procesos, hacer un aporte al medio ambiente y ahorrar papel, todas las actividades realizadas por la Facultad de Informática tendrán solamente certificados digitales</p>
                <p> <a class="btn btn-default" href="<?=\yii\helpers\Url::base('https')?>/img/ResCD-031-Ratificar-ResAdRef077-Certificados-Digitales-EXTescopia.pdf">ResCD Nro 031/20 &raquo;</a>
                    <a class="btn btn-default" href="<?=\yii\helpers\Url::base('https')?>/img/ResCD-064-Ratificar-ResAdRef117-Certificados-Digitales-Academica-SAescopia.pdf">ResCD Nro 064/20 &raquo;</a>
            </p>
<!--                <p><a class="btn btn-default" href="">Resolución XXX/20 &raquo;</a></p>-->
            </div>
            <div class="col-lg-4">
                <h2>Validación por codigo QR</h2>

                <p>Teniendo una copia digital se puede acceder mediante la lectura de código QR o mediante un código del certificado,
                utilizando como fuente auténtica el subdominio de la Facultad de Informática https://wene.fi.uncoma.edu.ar. El subdominio
                tiene certificación ssl.</p>

                <p><?= \yii\helpers\Html::a('Ver demo &raquo;', ['/certificado/view', 'hash' =>'ab514d' ,'pdf'=>'true'], ['class' => 'btn btn-default']);?>
<!--                    <a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>-->
            </div>
            <div class="col-lg-4">
                <h2>Válidos en CPE Neuquén</h2>

                <p>RESOLUCIÓN N°1135 / EXPEDIENTE N°8120-003418/2019 12/9/2019</p>

                <p><a class="btn btn-default" href="<?=\yii\helpers\Url::base('http')?>/img/r_1135_19.pdf">Resolución CPE 1135/19 &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
