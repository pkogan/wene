<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lote */

$this->title = 'Update Lote: ' . $model->idLote;
$this->params['breadcrumbs'][] = ['label' => 'Lotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idLote, 'url' => ['view', 'id' => $model->idLote]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
