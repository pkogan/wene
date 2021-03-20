<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "certificado".
 *
 * @property int $idCertificado
 * @property int $idPersona
 * @property int $idLote
 * @property int $idEstado
 * @property string $hash
 * @property string|null $observacion
 *
 * @property Estado $idEstado0
 * @property Persona $idPersona0
 * @property Lote $idLote0
 * @property int $adjunto
 */
class Certificado extends \yii\db\ActiveRecord {

    /**
     * @var UploadedFile
     */
    public $archivo;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'certificado';
    }

    public function nombreArchivo(){
        return '../archivos/adjuntos/' . $this->hash . '.pdf';
    }
    public function upload() {
        if ($this->validate()) {
            $this->archivo = \yii\web\UploadedFile::getInstance($this, 'archivo');
            if(($this->archivo)){
                $nombreArchivo=$this->nombreArchivo();
                if($this->archivo->saveAs($nombreArchivo)){
                    $this->archivo=null;
                    $this->adjunto=true;
                    return true;
               
                }else{
                    $this->addError('archivo', 'error al guardar el archivo');
                    return false;
                }
            }else{
                $this->adjunto=false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['archivo'], 'file', 'extensions' => 'pdf', 'maxSize' => 2048000, 'tooBig' => 'Archivo supera  2Mb'],
                [['idPersona', 'idLote', 'idEstado', 'hash'], 'required'],
                [['idPersona', 'idLote', 'idEstado'], 'integer'],
                [['adjunto'], 'boolean'],
                [['observacion'], 'string'],
                [['hash'], 'string', 'max' => 6],
                [['hash'], 'unique'],
                [['idPersona'], 'unique', 'targetAttribute' => ['idPersona', 'idLote']],
                [['idEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['idEstado' => 'idEstado']],
                [['idPersona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['idPersona' => 'idPersona']],
                [['idLote'], 'exist', 'skipOnError' => true, 'targetClass' => Lote::className(), 'targetAttribute' => ['idLote' => 'idLote']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idCertificado' => 'Id Certificado',
            'idPersona' => 'Id Persona',
            'idLote' => 'Id Lote',
            'idEstado' => 'Id Estado',
            'hash' => 'Hash',
            'observacion' => 'Observacion',
            'adjunto' => 'Adjunto'
        ];
    }

    /**
     * Gets query for [[IdEstado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado0() {
        return $this->hasOne(Estado::className(), ['idEstado' => 'idEstado']);
    }

    /**
     * Gets query for [[IdPersona0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdPersona0() {
        return $this->hasOne(Persona::className(), ['idPersona' => 'idPersona']);
    }

    /**
     * Gets query for [[IdLote0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdLote0() {
        return $this->hasOne(Lote::className(), ['idLote' => 'idLote']);
    }

    public function getLink() {
        return \yii\helpers\Url::base('https') . '/certificado/view?hash=' . $this->hash;
    }
    public function getLinkpdf() {
        return $this->getLink().'&pdf=1';
    }
    public function getFolderpath(){
        return '../archivos/certificados/'.$this->idLote0->idActividad.'/'.$this->idLote.'/';
    }
    public function getFilepath(){
        return $this->getFolderpath().$this->hash.'.pdf';
    }
    
    public function validarPermisos(){
          foreach ($this->idLote0->idActividad0->idDependencia0->usuarioDependencias as $usuarioDependencia){
                if(\Yii::$app->user->identity->idUsuario==$usuarioDependencia->idUsuario) return true;
            }
          throw new \yii\web\NotFoundHttpException('Está intentando acceder a un certificado de una actividad sobre la que no tiene permisos.');
     }

}
