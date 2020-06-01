<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ha ocurrido un error en el procesamiento de su request.
    </p>
    <p>
        Por favor contactarse con el administrador del servicio si entiende que es un error de la aplicación.
    </p>

</div>
