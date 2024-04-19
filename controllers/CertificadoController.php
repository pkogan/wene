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
                'only' => ['index', 'view', 'update', 'delete', 'create', 'mail', 'emitir', 'maillote', 'emitirlote', 'mis', 'norma'],
                'rules' => [
                    //'class' => AccessRule::className(),
                    [
                        'allow' => true,
                        'actions' => ['mis', 'view','norma'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'delete', 'create', 'mail', 'emitir', 'maillote','emitirlote','norma'],
                        'roles' => [\app\models\Rol::ROL_GESTOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view','norma'],
                        'roles' => ['?'],
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

    public function actionMis() {
        $searchModel = new CertificadoSearch();
        $personas = Yii::$app->user->identity->personas;

        if (count($personas) == 1) {


            $dni = $personas[0]->dni;
        } else {
            throw new \yii\web\NotAcceptableHttpException('El usuario no tiene una persona asociada');
        }
        $searchModel->dni = $dni;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;


        return $this->render('mis', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmitir($id) {
        $model = $this->findModel($id);
        $qrCode = $this->qr($model);
        $this->generar($model, $qrCode);
        $model->idEstado = \app\models\Estado::ESTADO_EMITIDO;
            if (!$model->save()) {
                throw new \yii\web\NotAcceptableHttpException('Error al guardar certificado');
            }
        return $this->render('ver', [
                    'model' => $model,
                    'qrCode' => $qrCode
        ]);
    }

    public function actionEmitirlote($id) {
        if (($lote = \app\models\Lote::findOne($id)) == null) {
            throw new \yii\web\NotAcceptableHttpException('Lote Inexistente');
        }
        $lote->validarPermisos();
        /*
         * se se generan todos los certificados
         */
        set_time_limit(1200);
        foreach ($lote->getCertificados()->all() as $model) {
            //print_r($model);exit();
            // if ($model->idEstado == \app\models\Estado::ESTADO_INICIAL) {
            $this->generar($model, $this->qr($model));
            $model->idEstado = \app\models\Estado::ESTADO_EMITIDO;
            if (!$model->save()) {
                throw new \yii\web\NotAcceptableHttpException('Error al guardar certificado');
            }
            //}
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

    public function actionNorma($hash) {
        /**
         * TODO: Unificar View y Ver
         */
        $model = Certificado::findOne(['hash' => $hash]);
        if ($model == null) {
            throw new \yii\web\NotAcceptableHttpException('Certificado Inexistente');
        }
        if(!is_null($model->idLote0->idActividad0->linkNorma)&&$model->idLote0->idActividad0->linkNorma!=''){
            return Yii::$app->getResponse()->redirect($model->idLote0->idActividad0->linkNorma);

        }else{
            throw new \yii\web\NotAcceptableHttpException('Certificado sin vinculo a Norma');
        }
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
             /**
             * Si está iniciado se genera temporal el pdf
             * En caso contrario:
              se busca en el sistema de archivos
              que exista el documento y se descarga
              si no se encuetra se genera el documento en la carpeta
              y se descarga
             */
            if ($model->idEstado == \app\models\Estado::ESTADO_INICIAL) {
                return $this->pdf($model, $qrCode);
            } else {
                //exit($model->getFilepath());
                if (!file_exists($model->getFilepath())) {
                    $this->generar($model, $qrCode);
                }
                return \Yii::$app->response->sendFile($model->getFilepath(),null,['inline'=>true]);
            }
        } else {
            return $this->render('ver', [
                        'model' => $model,
                        'qrCode' => $qrCode
            ]);
        }
    }

    private function generar($model, $qrCode) {
        $folder = $model->getFolderpath();
        if (!is_dir($folder)) {
            \yii\helpers\FileHelper::createDirectory($folder);
        }
        return $this->pdf($model, $qrCode, Pdf::DEST_FILE, $folder);
    }

    private function qr($model) {
        $qrCode = (new QrCode($model->getLink()))
                ->setSize(100)
                ->setMargin(5);
        $qrCode->writeFile(__DIR__ . '/../tmp/code.png'); // writer defaults to PNG when none is specified

        header('Content-Type: ' . $qrCode->getContentType());
        return $qrCode;
    }

    /**
     * 
     * @param Certificado $model
     * @param type $qrCode
     * @return type
     */
    private function pdf($model, $qrCode, $destination = Pdf::DEST_BROWSER, $folder = '') {
        /* @var $model Certificado */

        $content = $this->renderPartial('template/' . $model->idLote0->idTemplate0->template, ['model' => $model,
            'qrCode' => $qrCode]);
        /**
         * :Todo Abstraer hack header pdf en Dependencia
         */
        if (is_null($model->idLote0->idActividad0->idDependencia0->header)) {
            $header = 'Certificado Digital emitido por la Facultad de Informática de la Universidad Nacional del Comahue (<a href="' . \yii\helpers\Url::base('http') . '/img/ResCD-064-Ratificar-ResAdRef117-Certificados-Digitales-Academica-SAescopia.pdf">ResCD Nro 064/20</a>)';
        } else {
            $header = $model->idLote0->idActividad0->idDependencia0->header;
            //$header='Certificado Digital emitido por la Facultad de Informática de la Universidad Nacional del Comahue (<a href="' . \yii\helpers\Url::base('http') . '/img/ResCD-031-Ratificar-ResAdRef077-Certificados-Digitales-EXTescopia.pdf">ResCD Nro 031/20</a>)';
        }
        /**
         * :Todo Abstraer hack tamaño pdf en Template
         */
        if (substr($model->idLote0->idTemplate0->template,0,22)!='observatoriocredencial') {
            $format = Pdf::FORMAT_A4;
        } else {
            $format = 'A6';//'A6';//
            //$header='Certificado Digital emitido por la Facultad de Informática de la Universidad Nacional del Comahue (<a href="' . \yii\helpers\Url::base('http') . '/img/ResCD-031-Ratificar-ResAdRef077-Certificados-Digitales-EXTescopia.pdf">ResCD Nro 031/20</a>)';
        }

        // get your HTML raw content without any layouts or scripts
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            //'filename'=>$model->idLote0->idActividad0->fecha.str_replace(' ', '', $model->idPersona0->apellidoNombre).'_'.substr($model->idLote0->idTipoCertificado0->tipo,0,3).'_'.substr($model->idLote0->idActividad0->idTipoActividad0->tipo,0,3).'.pdf',
            'filename' => $folder . $model->hash . '.pdf',
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => $format,//'A6',//,
            // portrait orientation
            'orientation' => $model->idLote0->idTemplate0->orientacion,
            // stream to browser inline
            'destination' => $destination,
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
                'SetHeader' => [$header],
                'SetFooter' => ['<p>Se puede validar por QR, o el código ' . $model->hash . ' en</p>' .
                    '<p> <a href="' . \yii\helpers\Url::base('https') . '">https://wene.fi.uncoma.edu.ar <img style="padding-top:2px" height="12px" src="img/logolargonegro.png"/></a> </p> '],
                    //'SetFooter' => ['<p>Sistema de Certificados <img style="padding-top:2px" height="12px" src="img/logolargonegro.png"/> </p> ']
            ]
        ]);

        if ($model->adjunto) {
            $pdf->addPdfAttachment($model->nombreArchivo());
        }
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * 
     * @param Certificado $model
     * @return boolean
     * @throws \yii\web\NotAcceptableHttpException
     */
    private function mail($model) {
        $subject = 'Certificado - ';
        /* Hack cambiar del en el caso de por ejermplo Académica 
          Todo: ver forma de generalizar */
        if ($model->idLote0->idActividad0->idTipoActividad0->tipo == 'Académica') {
            $subject .= $model->idLote0->idActividad0->nombre;
        } else {
            $subject .= $model->idLote0->idActividad0->idTipoActividad0->tipo . ' ' . $model->idLote0->idActividad0->nombre;
        }
        //Yii::$app->components['mailer']['transport']['username']=$model->idLote0->idActividad0->idDependencia0->mail;
        if (!is_null($model->idLote0->idActividad0->idDependencia0->mail)) {
            Yii::$app->mailer->transport->setUsername($model->idLote0->idActividad0->idDependencia0->mail);
            Yii::$app->mailer->transport->setPassword($model->idLote0->idActividad0->idDependencia0->clave);
            Yii::$app->mailer->transport->setHost($model->idLote0->idActividad0->idDependencia0->smtp);
            //@todo: agregar dos campos a la dependencia Port y método para luego setearlos en cada envio
            //hack envío uncoma
            if(!is_null($model->idLote0->idActividad0->idDependencia0->port)) {
                Yii::$app->mailer->transport->setPort($model->idLote0->idActividad0->idDependencia0->port);
            }
            if(!is_null($model->idLote0->idActividad0->idDependencia0->protocol)&&$model->idLote0->idActividad0->idDependencia0->protocol!=='') {
                if(mb_strtoupper($model->idLote0->idActividad0->idDependencia0->protocol)=='PLAIN') {
                    Yii::$app->mailer->transport->setEncryption(null);
                }else{
                    Yii::$app->mailer->transport->setEncryption($model->idLote0->idActividad0->idDependencia0->protocol);
                }
            }
            $from = $model->idLote0->idActividad0->idDependencia0->mail;
        } else {
            $from = 'wene@fi.uncoma.edu.ar';
        }
        //print_r(Yii::$app->components);exit;

        if (Yii::$app->mailer->compose()
                        ->setFrom($from)//)
                        ->setTo(trim($model->idPersona0->mail))
                        ->setSubject($subject)
                        ->setHtmlBody('Estimadx, ' . mb_strtoupper($model->idPersona0->apellidoNombre,'UTF-8') .
                                ', este correo es enviado por el sistema Wene para gestión de Certificados desarrollado por la Facultad de Informática de la Universidad Nacional Comahue. ' .
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
        $model->validarPermisos();
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
        $lote->validarPermisos();
        /*
         * se envía mail a todo el lote en ESTADO_INICIAL a TOPE_MAIL_LOTE
         */
        $certificadosEstadoInicial = $lote->getCertificadosEstado(\app\models\Estado::ESTADO_EMITIDO)
                ->limit(\app\models\Lote::TOPE_MAIL_LOTE)
                ->all();

        foreach ($certificadosEstadoInicial as $model) {
            //print_r($model);exit();
            // if ($model->idEstado == \app\models\Estado::ESTADO_INICIAL) {
            $this->mail($model);
            $model->idEstado = \app\models\Estado::ESTADO_ENVIADO;
            if (!$model->save()) {
                throw new \yii\web\NotAcceptableHttpException('Error al guardar certificado');
            }
            //}
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
        $lote->validarPermisos();

        $model->idLote = $id;

        if ($model->load(Yii::$app->request->post())) {

            $model->hash = substr(md5(uniqid()), 0, 6);
            if ($model->upload() && $model->save()) {
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

        if ($model->load(Yii::$app->request->post()) && $model->upload() && $model->save()) {
            /*             * validar */
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
        $model = $this->findModel($id);
        $idLote = $model->idLote;
        $model->delete();
        return $this->redirect(['/lote/view', 'id' => $idLote]);
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
            if ($model->validarPermisos())
                return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
