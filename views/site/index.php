
<?php
    $this->title = 'Sistema de certificados - CURZA';
?>

<div class="site-index jumbotron">
    <div style="position: absolute; z-index: -1; opacity: 0.1; top:70%; left:50%; transform: translate(-50%, 0%);">
        <img src="img/logolargonegro.png" >
    </div>
    <div class="col-12">
        <img width="150px" src="img/curza.png" alt="Logo Centro Regional Zona Atlántica">
    </div>
    <h1 class="lead">Sistema de Certificados</h1>
    <h2>Centro Regional Zona Atlántica</h2>
        <?= yii\helpers\Html::a('Validar Certificados', ['/site/validar'], ['class' => 'btn btn-lg btn-primary']) ?>
        <?= yii\helpers\Html::a('Buscar mis Certificados', ['/certificado/mis'], ['class' => 'btn btn-lg btn-success']) ?>
</div>
