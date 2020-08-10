<?php

namespace app\controllers;

use Yii;
use app\models\UsuarioDependencia;
use app\models\UsuarioDependenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioDependenciaController implements the CRUD actions for UsuarioDependencia model.
 */
class UsuarioDependenciaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
                'only' => [ 'delete', 'create'],
                'rules' => [
                    //'class' => AccessRule::className(),
                        [
                        'allow' => true,
                        'actions' => ['delete', 'create'],
                        'roles' => [\app\models\Rol::ROL_ADMIN],
                    ],
                ],
            ],
            
        ];
    }




    /**
     * Creates a new UsuarioDependencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idUsuario)
    {
        $model = new UsuarioDependencia();
        $model->idUsuario=$idUsuario;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/usuario/view', 'id' => $model->idUsuario]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing UsuarioDependencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $idUsuario=$model->idUsuario;
        $model->delete();

        return $this->redirect(['/usuario/view', 'id' => $idUsuario]);
    }

    /**
     * Finds the UsuarioDependencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsuarioDependencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioDependencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
