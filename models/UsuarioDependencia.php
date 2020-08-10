<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarioDependencia".
 *
 * @property int $idUsuarioDependencia
 * @property int $idUsuario
 * @property int $idDependencia
 *
 * @property Usuario $idUsuario0
 * @property Dependencia $idDependencia0
 */
class UsuarioDependencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarioDependencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idDependencia'], 'unique', 'targetAttribute' => ['idUsuario', 'idDependencia']],
            [['idUsuario', 'idDependencia'], 'required'],
            [['idUsuario', 'idDependencia'], 'integer'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idDependencia'], 'exist', 'skipOnError' => true, 'targetClass' => Dependencia::className(), 'targetAttribute' => ['idDependencia' => 'idDependecia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUsuarioDependencia' => 'Id Usuario Dependencia',
            'idUsuario' => 'Id Usuario',
            'idDependencia' => 'Dependencia',
        ];
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[IdDependencia0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdDependencia0()
    {
        return $this->hasOne(Dependencia::className(), ['idDependecia' => 'idDependencia']);
    }
}
