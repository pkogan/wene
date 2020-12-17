<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
         if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol== app\models\Rol::ROL_GESTOR){
             echo Html::a('Create Actividad', ['create'], ['class' => 'btn btn-success']);
         }?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idActividad',
            //'idTipoActividad0.tipo',
            ['attribute' => 'idTipoActividad',
                'label' => 'Tipo',
                'value'=>'idTipoActividad0.tipo',
                'filter' => \yii\helpers\ArrayHelper::map(
                \app\models\TipoActividad::find()->all()
                        , 'idTipo', 'tipo'),
                ],
            //'idDependencia0.nombre',
            ['attribute' => 'idDependencia',
                'label' => 'Dependencia',
                'value'=>'idDependencia0.nombre',
                'filter' => \yii\helpers\ArrayHelper::map(
                        \app\models\Dependencia::find()->joinWith('usuarioDependencias')->where(['idUsuario'=> \Yii::$app->user->identity->idUsuario])->all()
                        , 'idDependecia', 'nombre'),
                ]
            ,
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
