<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateDependencia */

$this->title = 'Update Template Dependencia: ' . $model->idTemplateDependencia;
$this->params['breadcrumbs'][] = ['label' => 'Template Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idTemplateDependencia, 'url' => ['view', 'id' => $model->idTemplateDependencia]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-dependencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
