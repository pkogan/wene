<?php

namespace app\controllers;

use app\mail\UserRecoveryMail;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\dto\UserMail;
use kartik\mpdf\Pdf;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                        [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $model=new \app\models\CertForm();
        $model->hash='ab514d';
        return $this->render('index',['model'=>$model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        if ($model->load(Yii::$app->request->get()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionValidar() {
        
        return $this->render('validar' );
        
    }
    
    public function actionRecuperar()
    {
        $model = new \app\models\RecuperarclaveForm();
        $model->mail = '';

        if ($model->load(Yii::$app->request->post())) {

            if (!$model->mail == '') {

                $modelRegistro = \app\models\Persona::find()
                        ->where('mail="' . $model->mail . '"')
                        ->one();

                if (!is_null($modelRegistro)) {
                    
                    $nuevaClave = substr(md5(time()), 0, 6);
        
                    if (is_null($modelRegistro->idUsuario)) {
                        //crear usuario
                        $usuario= new \app\models\Usuario();
                        $usuario->nombreUsuario=$modelRegistro->mail;
                        $usuario->clave = $nuevaClave;
                        $usuario->idRol = \app\models\Rol::ROL_CERTIFICANTE;

                        if(!$usuario->save()) {
                            throw new \yii\base\UserException('no pudo guardar el usuario');
                        }

                        $modelRegistro->idUsuario = $usuario->idUsuario;
                        if(!$modelRegistro->save()){
                            throw new \yii\base\UserException('no pudo vincular el usuario');
                        }
                        
                     } else {
                         $modelRegistro->idUsuario0->clave = $nuevaClave;
                         if (!$modelRegistro->idUsuario0->save()) {
                            throw new \yii\base\UserException('no pudo actualizar la clave');
                         }
                     }

                    UserRecoveryMail::send(
                        UserMail::instantiateFromPerson(
                            $modelRegistro,
                            $nuevaClave
                        )
                    );

                    return $this->render('mensaje', ['mensaje' => 'Se le ha enviado un Correo Electrónico. Revise su casilla']);
                } else {
                    $model->addError('mail', 'el Correo es incorrecto o no está cargado. Si el problema persiste vuelva a registrarse');
                }
            }
        }

        return $this->render('recuperar', ['model' => $model]);
    }

    /**
     * @deprecated maybe?
     */
    protected function envioMail($modelRegistro,$masivo=false) {
            Yii::$app->mailer->compose()
                    ->setFrom('wene@fi.uncoma.edu.ar')
                    ->setTo($modelRegistro->mail)
                    ->setSubject('Datos para descargar certificados del sistema wene')
                    ->setHtmlBody('<p>Estomadx, ' . $modelRegistro->apellidoNombre .
                            ', este correo es enviado por el sistema wene (sistema de Certificados). Ingrese al siguiente ' . \yii\helpers\Html::a('link', \yii\helpers\Url::base('https') . '/site/login?LoginForm[username]=' . $modelRegistro->idUsuario0->nombreUsuario.'&LoginForm[password]=' . $modelRegistro->idUsuario0->clave) .
                            ' para descargar y ver el historial de sus certificados. '.'</p>'
                            . '<p><b>Para próximos ingresos, su usuario es: '.$modelRegistro->idUsuario0->nombreUsuario. ' y su clave es: '. $modelRegistro->idUsuario0->clave.'</p> <p>Muchas Gracias.</b><p>')
                    ->send();

            if(!$masivo) return $this->render('mensaje', ['mensaje' => 'Se le ha enviado un Correo Electrónico. Revise su casilla']);
       
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionDemo($hash,$pdf=false) {
        if ($hash != substr(md5('demo'),0,7)) {
            throw new \yii\web\MethodNotAllowedHttpException('Certificado Erroneo');
            //Yii::warning("Certificado Erroneo");
        }
        $model = [];
        $model['title']='Certificado de Aprobación';
        $model['hash'] = $hash;
        if($pdf){
            return $this->pdf($model);
        }else{
            return $this->render('demo', ['model' => $model]);
        }
    }

    public function pdf($model) {
        
        $content = $this->renderPartial('_cert', ['model' => $model]);
        // get your HTML raw content without any layouts or scripts
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssFile' => 'css/site.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Certificado sistema wene'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Certificado Digital emitido por la Facultad de Informática de la Universidad Nacional del Comahue (<a>Res. XXX/20</a>)'],
                'SetFooter' => ['wene - Sistema de Certificados'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
