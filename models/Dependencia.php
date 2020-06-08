<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dependencia".
 *
 * @property int $idDependecia
 * @property string $nombre
 * @property int|null $idDependenciaPadre
 *
 * @property Actividad[] $actividads
 */
class Dependencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dependencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['idDependenciaPadre'], 'integer'],
            [['nombre'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idDependecia' => 'Id Dependecia',
            'nombre' => 'Dependencia',
            'idDependenciaPadre' => 'Id Dependencia Padre',
        ];
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['idDependencia' => 'idDependecia']);
    }
}
