<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoCertificado".
 *
 * @property int $idTipoCertificado
 * @property string $tipo
 *
 * @property Lote[] $lotes
 */
class TipoCertificado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoCertificado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'required'],
            [['tipo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idTipoCertificado' => 'Id Tipo Certificado',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Lotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLotes()
    {
        return $this->hasMany(Lote::className(), ['idTipoCertificado' => 'idTipoCertificado']);
    }
}
