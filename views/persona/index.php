<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Persona', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'idPersona',
//            'idUsuario',
            'mail',
            'dni',
            'legajo',
            'apellidoNombre',
            ['attribute' => 'idDependencia',
                'label' => 'Dependencia',
                'value'=>'idDependencia0.nombre',
                'filter' => \yii\helpers\ArrayHelper::map(
                        \app\models\Dependencia::find()->joinWith('usuarioDependencias')->where(['idUsuario'=> \Yii::$app->user->identity->idUsuario])->all()
                        , 'idDependecia', 'nombre'),
                ]
            ,
            //'telefono',
            //'localidad',
            //'Comentario',
            //'idCiudad',
            //'token',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
