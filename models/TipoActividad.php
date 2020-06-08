<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoActividad".
 *
 * @property int $idTipo
 * @property string $tipo
 *
 * @property Actividad[] $actividads
 */
class TipoActividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoActividad';
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
            'idTipo' => 'Id Tipo',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['idTipoActividad' => 'idTipo']);
    }
}
