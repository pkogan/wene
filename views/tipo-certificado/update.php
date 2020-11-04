<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoCertificado */

$this->title = 'Update Tipo Certificado: ' . $model->idTipoCertificado;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Certificados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idTipoCertificado, 'url' => ['view', 'id' => $model->idTipoCertificado]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-certificado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
