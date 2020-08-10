<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lote".
 *
 * @property int $idLote
 * @property int $idActividad
 * @property int $idEstado
 * @property int $idTipoCertificado
 * @property int $idTemplate
 * @property string $fechaEmision
 * @property string|null $observacion
 *
 * @property Certificado[] $certificados
 * @property Template $idTemplate0
 * @property Actividad $idActividad0
 * @property Estado $idEstado0
 * @property TipoCertificado $idTipoCertificado0
 */
class Lote extends \yii\db\ActiveRecord


{
    const TOPE_MAIL_LOTE = 50;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idActividad', 'idEstado', 'idTipoCertificado', 'idTemplate', 'fechaEmision'], 'required'],
            [['idActividad', 'idEstado', 'idTipoCertificado', 'idTemplate'], 'integer'],
            [['fechaEmision'], 'safe'],
            [['observacion'], 'string'],
            [['idTemplate'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['idTemplate' => 'idTemplate']],
            [['idActividad'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['idActividad' => 'idActividad']],
            [['idEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['idEstado' => 'idEstado']],
            [['idTipoCertificado'], 'exist', 'skipOnError' => true, 'targetClass' => TipoCertificado::className(), 'targetAttribute' => ['idTipoCertificado' => 'idTipoCertificado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLote' => 'Id Lote',
            'idActividad' => 'Id Actividad',
            'idEstado' => 'Id Estado',
            'idTipoCertificado' => 'Id Tipo Certificado',
            'idTemplate' => 'Id Template',
            'fechaEmision' => 'Fecha Emision',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * Gets query for [[Certificados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificados()
    {
        return $this->hasMany(Certificado::className(), ['idLote' => 'idLote']);
    }

    public function getCertificadosEstado($idEstado=null){
         if($idEstado==null){
            return $this->getCertificados();
        }else{
            return $this->hasMany(Certificado::className(), ['idLote' => 'idLote'])
                    ->andOnCondition(['certificado.idEstado'=>$idEstado]);
        }
    }
    
    public function getCountCertificados($idEstado=null)
    {
        if($idEstado==null){
            return $this->getCertificados()->count();
        }else{
            return $this->getCertificadosEstado($idEstado)->count();
        }
        
    }
    
    /**
     * Gets query for [[IdTemplate0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTemplate0()
    {
        return $this->hasOne(Template::className(), ['idTemplate' => 'idTemplate']);
    }

    /**
     * Gets query for [[IdActividad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdActividad0()
    {
        return $this->hasOne(Actividad::className(), ['idActividad' => 'idActividad']);
    }

    /**
     * Gets query for [[IdEstado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado0()
    {
        return $this->hasOne(Estado::className(), ['idEstado' => 'idEstado']);
    }

    /**
     * Gets query for [[IdTipoCertificado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoCertificado0()
    {
        return $this->hasOne(TipoCertificado::className(), ['idTipoCertificado' => 'idTipoCertificado']);
    }
    public function getFechaTexto()
    {
       return DateSpanish::cadena($this->fechaEmision);
        
    }
    
    public function validarPermisos(){
          foreach ($this->idActividad0->idDependencia0->usuarioDependencias as $usuarioDependencia){
                if(\Yii::$app->user->identity->idUsuario==$usuarioDependencia->idUsuario) return true;
            }
          throw new \yii\web\NotFoundHttpException('Está intentando acceder a un lote de una actividad sobre la que no tiene permisos.');
     }
    
}
