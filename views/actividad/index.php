<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Actividad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idActividad',
            'idTipoActividad0.tipo',
            'idDependencia0.nombre',
            //'idActividadPadre',
            'nombre',
            //'descripcion:ntext',
            'fecha:date',
            //'norma',
            //'idCiudad',
            //'duracion',
            //'observaciones:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
