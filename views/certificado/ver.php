<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Certificado */

$this->title = 'Certificado #'.$model->hash. ' '. $model->idPersona0->apellidoNombre;
if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol== app\models\Rol::ROL_GESTOR){
$actividad=$model->idLote0->idActividad0;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['/actividad/index']];
$this->params['breadcrumbs'][] = ['label'=> $actividad->idTipoActividad0->tipo. ': '. $actividad->nombre,
    'url'=>['/actividad/view','id'=>$actividad->idActividad]];
$this->params['breadcrumbs'][] = ['label' => 'Lote #'.$model->idLote0->idLote, 'url' => ['/lote/view','id'=>$model->idLote0->idLote]];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);




?>
<div class="certificado-view">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <p>
<?= Html::a('Descargar PDF', ['view', 'hash' => $model->hash, 'pdf'=>true], ['class' => 'btn btn-success']) ?>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idRol== app\models\Rol::ROL_GESTOR){
         echo Html::a('Emitir', ['emitir', 'id' => $model->idCertificado], ['class' => 'btn btn-warning',
                 'data'=>['confirm' => '¿Está seguro de emitir certificado? Podria eliminar datos frizados',
                'method' => 'post',]]). ' ';
         echo Html::a('Comunicar', ['mail', 'hash' => $model->hash], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => '¿Está seguro de enviar certificado por mail a '.$model->idPersona0->mail.'?',
                'method' => 'post',
            ],
        ]).' ';
         
         echo Html::a('Actualizar', ['update', 'id' => $model->idCertificado], ['class' => 'btn btn-primary']). ' ';
        
         echo Html::a('Borrar', ['delete', 'id' => $model->idCertificado], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de borrar el certificado?',
                'method' => 'post',
            ],
        ]).' ';
        echo Html::a('Actualizar Persona', ['/persona/update', 'id' => $model->idPersona], ['class' => 'btn btn-primary']). ' ';
    }
?>
    </p>
    <?= $this->render('template/basico',//'.$model->idLote0->idTemplate0->template,
        //$this->render('template/'.$model->idLote0->idTemplate0->template,
             ['model'=>$model,
                 'qrCode'=>$qrCode])?>

</div>
