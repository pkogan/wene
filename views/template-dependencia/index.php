<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TemplateDependenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Template Dependencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-dependencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Template Dependencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idTemplateDependencia',
            'idTemplate',
            'idDependencia',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
