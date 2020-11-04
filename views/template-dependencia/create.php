<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateDependencia */

$this->title = 'Create Template Dependencia';
$this->params['breadcrumbs'][] = ['label' => 'Template Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-dependencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
