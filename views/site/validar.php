<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;

/* @var $this yii\web\View */
/* @var $model app\models\Entrega */

$this->title = 'Validar Certificado';
//$this->params['breadcrumbs'][] = ['label' => 'Entregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<p>Para validar la autenticidad del documento, ingrese el código que se encuentra en la parte inferior derecha del certificado, o acceda al link del código QR que se encuentra en la parte inferior del certificado.</p>
<?= $this->render('_formcert', ['model' => new \app\models\CertForm()]);?>