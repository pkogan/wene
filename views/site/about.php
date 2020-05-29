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
</div>
