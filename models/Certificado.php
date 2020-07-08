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
 */
class Certificado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPersona', 'idLote', 'idEstado', 'hash'], 'required'],
            [['idPersona', 'idLote', 'idEstado'], 'integer'],
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
    public function attributeLabels()
    {
        return [
            'idCertificado' => 'Id Certificado',
            'idPersona' => 'Id Persona',
            'idLote' => 'Id Lote',
            'idEstado' => 'Id Estado',
            'hash' => 'Hash',
            'observacion' => 'Observacion',
        ];
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
     * Gets query for [[IdPersona0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdPersona0()
    {
        return $this->hasOne(Persona::className(), ['idPersona' => 'idPersona']);
    }

    /**
     * Gets query for [[IdLote0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdLote0()
    {
        return $this->hasOne(Lote::className(), ['idLote' => 'idLote']);
    }
    	   public function getLink(){ 
       return \yii\helpers\Url::base('http') . '/certificado/view?hash=' . $this->hash; 
   } 
}
