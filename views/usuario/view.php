<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->idUsuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idUsuario], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->idUsuario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idUsuario',
            'nombreUsuario',
            'clave',
            'idRol0.nombre',
        ],
    ])
    ?>

    <p>
    <?= Html::a('Agregar Dependencia', ['/usuario-dependencia/create', 'idUsuario' => $model->idUsuario], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['label' => 'Dependencia', 'value' => 'idDependencia0.nombre'],
                ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                /*'buttons' => [
                    'delete' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-delete"></span>', $url, [
                                    'title' => Yii::t('yii', 'Borrar'),
                                    'data' => [
                                        'confirm' => 'Está seguro de borrar los permisos sobre ' . $model->idDependencia0->nombre,
                                    //'method' => 'post',
                                    ],
                        ]);
                    }
                ],*/
                'urlCreator' => function( $action, $model, $key, $index ) {
                    /* if ($action == "update") {
                      return \yii\helpers\Url::to(['/certificado/view', 'id' => $key]);
                      } */
                    if ($action == "delete") {
                        return \yii\helpers\Url::to(['/usuario-dependencia/delete', 'id' => $model->idUsuarioDependencia]);
                    }
                }],
        ],
    ]);
    ?>

</div>
