<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Entrega */

$this->title = 'Certificado #' . $model['hash'];
//$this->params['breadcrumbs'][] = ['label' => 'Entregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= Html::a('Descargar pdf', ['demo', 'hash' => $model['hash'],'pdf'=>'true'], ['class' => 'btn btn-primary']). ' ';?>
<?= $this->render('_cert', ['model' => $model]);?>
<p>Validar nuevo Certificado</p>
<?= $this->render('_formcert', ['model' => new \app\models\CertForm()]);?>