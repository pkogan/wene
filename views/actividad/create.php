<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

$this->title = 'Create Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
