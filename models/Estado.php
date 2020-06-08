<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property int $idEstado
 * @property string $estado
 *
 * @property Certificado[] $certificados
 * @property Lote[] $lotes
 */
class Estado extends \yii\db\ActiveRecord
{
    const ESTADO_INICIAL = 1;
    const ESTADO_EMITIDO = 2;
    const ESTADO_ENVIADO = 3;
    const ESTADO_RECIBIDO = 4;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'required'],
            [['estado'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEstado' => 'Id Estado',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Certificados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificados()
    {
        return $this->hasMany(Certificado::className(), ['idEstado' => 'idEstado']);
    }

    /**
     * Gets query for [[Lotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLotes()
    {
        return $this->hasMany(Lote::className(), ['idEstado' => 'idEstado']);
    }
}
