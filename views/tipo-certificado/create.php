<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoCertificado */

$this->title = 'Create Tipo Certificado';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Certificados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-certificado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
