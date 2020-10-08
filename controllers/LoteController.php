<?php

namespace app\controllers;

use Yii;
use app\models\Lote;
use app\models\LoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoteController implements the CRUD actions for Lote model.
 */
class LoteController extends Controller {

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
                'only' => ['index', 'view', 'update', 'delete', 'create'],
                'rules' => [
                    //'class' => AccessRule::className(),
                        [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'roles' => [\app\models\Rol::ROL_GESTOR],
                    ],
                        [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [\app\models\Rol::ROL_HACEDOR],
                    ],
                ],
            ],
        ];
    }

    public function actionImportar($id) {
        $lote = $this->findModel($id);
        $model = new \app\models\ImportarLoteForm();
        $rows = [];
        $contadores = [];

        /*
         * se solicita archivo csv formato dni,obs
         */


        if ($model->load(Yii::$app->request->post())) {

            $model->archivo = \yii\web\UploadedFile::getInstance($model, 'archivo');

            if ($model->archivo) {
                $time = time();
                $nombre = '../tmp/lote' . $lote->idLote . '_' . $time . '.' . $model->archivo->extension;
                $model->archivo->saveAs($nombre);
                $handle = fopen($nombre, "r");
                $contadores['error en archivo'] = 0;
                $contadores['registros'] = 0;

                $contadores['no existe persona'] = 0;
                $contadores['persona importada'] = 0;
                $contadores['error al guardar persona'] = 0;
                $contadores['importados'] = 0;
                $contadores['error al guardar certificado'] = 0;


                while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
                    //print_r($fileop);
                    $contadores['registros'] ++;
                    $row = [];
                    if (isset($fileop[0]) && isset($fileop[1])) {
                        $row['dni'] = $fileop[0];
                        $row['obs'] = $fileop[1];
                        $persona = \app\models\Persona::findOne((['dni' => $row['dni']]));
                        if ($persona == null) {
                            $row['msj'] = 'No Existe Persona con DNI ingresado';
                            if (isset($fileop[3]) && isset($fileop[2])) {
                                $contadores['no existe persona'] ++;
                                $persona = new \app\models\Persona();
                                $persona->dni = $row['dni'];
                                $persona->mail = $fileop[3];
                                $persona->apellidoNombre = $fileop[2];
                                if(isset($fileop[4])){
                                    $persona->legajo=$fileop[4];
                                }
                                if (!$persona->save()) {
                                    $row['msj'] .= '. Error al guardar Persona';
                                    foreach ($persona->errors as $atributo => $errores)
                                        $row['msj'] .= ', ' . $atributo . ': ' . implode(', ', $errores);
                                    $contadores['error al guardar persona'] ++;
                                    $persona = null;
                                } else {
                                    $row['msj'] .= '. Persona importada ok';
                                    $contadores['persona importada'] ++;
                                }
                            } else {
                                $row['msj'] .= '. Error al guardar Persona no cargó columnas 3 y 4';
                                $contadores['error al guardar persona'] ++;
                            }
                        }
                        if ($persona != null) {
                            $certificado = new \app\models\Certificado();
                            $certificado->idPersona = $persona->idPersona;
                            $certificado->idLote = $id;
                            $certificado->idEstado = \app\models\Estado::ESTADO_INICIAL;
                            $certificado->hash = substr(md5(uniqid()), 0, 6);
                            $certificado->observacion = $row['obs'];
                            if (!$certificado->save()) {
                                $row['msj'] = 'Error al guardar Certificado';
                                foreach ($certificado->errors as $atributo => $errores)
                                    $row['msj'] .= ', ' . $atributo . ': ' . implode(', ', $errores);
                                $contadores['error al guardar certificado'] ++;
                            } else {
                                $row['msj'] = 'ok';
                                $contadores['importados'] ++;
                            }
                            //$row['certificado']=$certificado;
                        }
                        $rows[] = $row;
                    } else {
                        $contadores['error en archivo'] ++;
                    }
                }
                //print_r($rows);
            }
        }


        /*
         * se valida el archivo
         * que existan dni repetidos
         * que existan los dni en la base de datos
         */

        /*
         * se insertan los certificados
         */

        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => false
        ]);

        return $this->render('importar', [
                    'model' => $lote,
                    'provider' => $provider,
                    'contadores' => $contadores,
                    'modelform' => $model
        ]);
    }

    /**
     * Lists all Lote models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lote model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $searchModel = new \app\models\CertificadoSearch();
        $searchModel->idLote = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Lote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        if (($actividad = \app\models\Actividad::findOne($id)) == null) {
            throw new Exception('No existe la Activiadad');
        }
        $actividad->validarPermisos();

        $model = new Lote();
        $model->idActividad = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idLote]);
        }
        if(is_null($model->observacion)){
            $model->observacion=$actividad->descripcion;
        }

        return $this->render('create', [
                    'model' => $model,
                    'actividad' => $actividad
        ]);
    }

    /**
     * Updates an existing Lote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idLote]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model=$this->findModel($id);
        $idActividad=$model->idActividad;
        $model->delete();

        return $this->redirect(['/actividad/view','id'=>$idActividad]);
    }

    /**
     * Finds the Lote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Lote::findOne($id)) !== null) {
               if($model->validarPermisos()) return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
