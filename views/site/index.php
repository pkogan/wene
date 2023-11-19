
<?php
    $this->title = 'Sistema de certificados - CURZA';
?>

<div class="site-index jumbotron">
    <div style="position: absolute; z-index: -1; opacity: 0.05; top:70%; left:50%; transform: translate(-50%, 0%);">
        <img src="img/logolargonegro.png" >
    </div>
    <div class="col-12">
        <img width="150px" src="img/curza.png" alt="Logo Centro Regional Zona Atlántica">
    </div>
    <h1 class="lead">Sistema de Certificados</h1>
    <h2>Centro Regional Zona Atlántica</h2>
    <div style="margin-top: 16px; margin-bottom: 16px;">
        <?= yii\helpers\Html::a('Validar Certificados', ['/site/validar'], ['class' => 'btn btn-lg btn-primary']) ?>
        <?= yii\helpers\Html::a('Buscar mis Certificados', ['/certificado/mis'], ['class' => 'btn btn-lg btn-success']) ?>
    </div>
    <div style="margin-top: 16px" class="col-12">
        <h2>Sobre Wene</h2>
        <p>
            Esta herramienta simplifica el proceso de emisión y verificación de certificados de cursos en todas las delegaciones del CURZA
        </p>
        <p>
            ¿Qué hace a Wene tan especial? No solo emite certificados de manera eficiente, sino que también te brinda la capacidad de verificar la autenticidad de cualquier certificado emitido a través de este sistema.
        </p>
        <p>
            Además, tenés la posibilidad de crear tu propio perfil personalizado. Con un perfil en Wene, puedes consultar tus logros académicos en cualquier momento y desde cualquier lugar.
        </p>
    </div>
       <div class="logos_pie">

        <h5>Actividades organizadas de conjunto con:</h5>
        <img src="<?= yii\helpers\Url::home();?>img/uncoma.png" alt="UNCo"/>
        <img src="<?= yii\helpers\Url::home();?>img/faif.png" alt="Facultad de Informática"/>
        <img src="<?= yii\helpers\Url::home();?>img/fahu.jpeg" alt="Facultad de Humanidades"/>
        <img src="<?= yii\helpers\Url::home();?>img/RRII.png" alt="Subsecretaría de Relaciones Internacionales"/>
            <img src="<?= yii\helpers\Url::home();?>img/sadosky.png" alt="Sadosky"/>
            <img src="<?= yii\helpers\Url::home();?>img/logo-redunci.gif" alt="RedUnci"/>
            <img src="<?= yii\helpers\Url::home();?>img/aten.png" alt="aten"/>
            <img src="<?= yii\helpers\Url::home();?>img/pagagonialibreredondo.png" alt="Patagonialibre"/>
            <img src="<?= yii\helpers\Url::home();?>img/patagonian.png" alt="Patagonian"/>
            <img src="<?= yii\helpers\Url::home();?>img/gdg.png" alt="GDGNeuquen"/>



        </div>

</div>
