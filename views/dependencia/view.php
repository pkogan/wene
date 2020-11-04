<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dependencia */

$this->title = $model->idDependecia;
$this->params['breadcrumbs'][] = ['label' => 'Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dependencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idDependecia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idDependecia], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idDependecia',
            'nombre',
            'idDependenciaPadre',
        ],
    ]) ?>
    <h2>Templates</h2>
    <p>
    <?= Html::a('Agregar Template', ['/template-dependencia/create', 'id' => $model->idDependecia], ['class' => 'btn btn-success']) ?>
    </p>

     <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idTemplateDependencia',
            'idTemplate0.template',
            //'idDependencia',

            //['class' => 'yii\grid\ActionColumn'],
              ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                
                'urlCreator' => function( $action, $model, $key, $index ) {
                    /* if ($action == "update") {
                      return \yii\helpers\Url::to(['/certificado/view', 'id' => $key]);
                      } */
                    if ($action == "delete") {
                        return \yii\helpers\Url::to(['/template-dependencia/delete', 'id' => $model->idTemplateDependencia]);
                    }
                }],
        ],
    ]); ?>
</div>
