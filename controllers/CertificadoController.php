<?php

namespace app\controllers;

use Yii;
use app\models\Certificado;
use app\models\CertificadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\QrCode\QrCode;
use kartik\mpdf\Pdf;

/**
 * CertificadoController implements the CRUD actions for Certificado model.
 */
class CertificadoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => \app\models\AccessRule::className(),
                ],
                'only' => ['index', 'view', 'update', 'delete', 'create', 'mail', 'maillote'],
                'rules' => [
                    //'class' => AccessRule::className(),
                        [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'delete', 'create', 'mail', 'maillote'],
                        'roles' => [\app\models\Rol::ROL_GESTOR],
                    ],
                        [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?', \app\models\Rol::ROL_HACEDOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Certificado models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CertificadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($hash, $pdf = false) {
        /**
         * TODO: Unificar View y Ver
         */
        $model = Certificado::findOne(['hash' => $hash]);
        if ($model == null) {
            throw new \yii\web\NotAcceptableHttpException('Certificado Inexistente');
        }
        $qrCode = $this->qr($model);
        //print_r($model); exit;
        if ($pdf) {
            return $this->pdf($model, $qrCode);
        } else {
            return $this->render('ver', [
                        'model' => $model,
                        'qrCode' => $qrCode
            ]);
        }
    }

    private function qr($model) {
        $qrCode = (new QrCode($model->getLink()))
                ->setSize(100)
                ->setMargin(5);
        $qrCode->writeFile(__DIR__ . '/../tmp/code.png'); // writer defaults to PNG when none is specified

        header('Content-Type: ' . $qrCode->getContentType());
        return $qrCode;
    }

    private function pdf($model, $qrCode) {
        /* @var $model Certificado */

        $content = $this->renderPartial('template/' . $model->idLote0->idTemplate0->template, ['model' => $model,
            'qrCode' => $qrCode]);
        // get your HTML raw content without any layouts or scripts
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            //'filename'=>$model->idLote0->idActividad0->fecha.str_replace(' ', '', $model->idPersona0->apellidoNombre).'_'.substr($model->idLote0->idTipoCertificado0->tipo,0,3).'_'.substr($model->idLote0->idActividad0->idTipoActividad0->tipo,0,3).'.pdf',
            'filename' => $model->hash . '.pdf',
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile' => '@vendor/bower-asset/bootstrap/dist/css/bootstrap.css',
            //'cssFile' => '@app/web/assets/bc3439ae/css/bootstrap.css',
            //'cssFile' => 'css/site.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            //'options' => ['title' => 'Certificado sistema wene'],
            // call mPDF methods on the fly
            'marginLeft' => 15,
            'marginRight' => 15,
            'methods' => [
                'SetHeader' => ['Certificado Digital emitido por la Facultad de Informática de la Universidad Nacional del Comahue (<a href="'.\yii\helpers\Url::base('http').'/img/ResDecAdRef-077-Sistema-Reintegro-Certificados-Digitales-EXT-2020.pdf">Res. AdRef Nro 077/20</a>)'],
                'SetFooter' => ['<p>Se puede validar el Certificado, accediendo al link del código QR, o a <a href="'.\yii\helpers\Url::base('https').'">'.\yii\helpers\Url::base('https').'</a> con el código '.$model->hash.'</p>'.
                     'Sistema de Certificados <img style="padding-top:2px" height="12px" src="img/logolargonegro.png"/>  '],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    private function mail($model) {
        if (Yii::$app->mailer->compose()
                        ->setFrom('pablo.kogan@fi.uncoma.edu.ar')
                        ->setTo($model->idPersona0->mail)
                        ->setSubject('Certificado del ' . $model->idLote0->idActividad0->idTipoActividad0->tipo . ' ' . $model->idLote0->idActividad0->nombre)
                        ->setHtmlBody('Estimadx, ' . $model->idPersona0->apellidoNombre .
                                ', este correo es enviado por el sistema (wene.fi.uncoma.edu.ar) de Certificados emitidos por la Facultad de Informática de la Universidad Nacional Comahue. ' .
                                ' Ingrese al siguiente ' . \yii\helpers\Html::a('link', $model->getLink()) . ' para descargar su certificado.  Muchas Gracias.')
                        ->send()) {
            return true;
        } else {
            throw new \yii\web\NotAcceptableHttpException('Error al enviar mail');
        }
    }

    /**
     * 
     * @param type $hash
     * @param type $pdf
     * @return type
     * @throws \yii\web\NotAcceptableHttpException
     * 
     * Envia mail
     */
    public function actionMail($hash) {

        $model = Certificado::findOne(['hash' => $hash]);
        if ($model == null) {
            throw new \yii\web\NotAcceptableHttpException('Certificado Inexistente');
        }
        $this->mail($model);
        /**
         * actualizar estado
         */
        $model->idEstado = \app\models\Estado::ESTADO_ENVIADO;
        if ($model->save()) {
            return $this->redirect(['view', 'hash' => $model->hash]);
        } else {
            throw new \yii\web\NotAcceptableHttpException('Error al guardar');
        }
    }

    public function actionMaillote($id) {
        if (($lote = \app\models\Lote::findOne($id)) == null) {
            throw new \yii\web\NotAcceptableHttpException('Lote Inexistente');
        }
        /*
         * se envía mail a todo el lote
         */
        foreach ($lote->certificados as $model) {
            $this->mail($model);
            $model->idEstado = \app\models\Estado::ESTADO_ENVIADO;
            if (!$model->save()) {
                throw new \yii\web\NotAcceptableHttpException('Error al guardar certificado');
            }
        }
        /**
         * actualizar estado del lote
         */
        $lote->idEstado = \app\models\Estado::ESTADO_ENVIADO;
        if ($lote->save()) {
            return $this->redirect(['/lote/view', 'id' => $id]);
        } else {
            throw new \yii\web\NotAcceptableHttpException('Error al guardar lote');
        }
    }

    /**
     * Displays a single Certificado model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionViewOld($id) {
//        $model=$this->findModel($id);
//        $qrCode=$this->qr($model);
//        return $this->render('ver', [
//                    'model' => $model,
//                    'qrCode'=> $qrCode
//        ]);
//    }

    /**
     * Creates a new Certificado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        /*
         * TODO: Autoasignar hash
         */
        $model = new Certificado();
        if (($lote = \app\models\Lote::findOne($id)) == null) {
            throw new Exception('Lote Inexistente');
        }

        $model->idLote = $id;

        if ($model->load(Yii::$app->request->post())){
            
            $model->hash=substr(md5(uniqid()),0,6);
            if($model->save()) {
                       return $this->redirect(['view', 'hash' => $model->hash]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'lote' => $lote,
        ]);
    }

    /**
     * Updates an existing Certificado model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'hash' => $model->hash]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Certificado model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Certificado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Certificado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Certificado::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
