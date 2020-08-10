<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioDependencia */

$this->title = 'Asignar Dependencia';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['/usuario/index']];
$this->params['breadcrumbs'][] = ['label' => $model->idUsuario, 'url' => ['/usuario/view','id'=>$model->idUsuario]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-dependencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
