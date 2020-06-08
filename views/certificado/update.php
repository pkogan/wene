<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Certificado */

$this->title = 'Update Certificado: ' . $model->idCertificado;
$this->params['breadcrumbs'][] = ['label' => 'Certificados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idCertificado, 'url' => ['view', 'id' => $model->idCertificado]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="certificado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
