<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dependencia".
 *
 * @property int $idDependecia
 * @property string $nombre
 * @property int|null $idDependenciaPadre
 * @property string|null $mail
 * @property string|null $clave
 * @property string|null $smtp
 * @property string|null $header
 *
 * @property Actividad[] $actividads
 * @property TemplateDependencia[] $templateDependencias
 * @property UsuarioDependencia[] $usuarioDependencias
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
            [['mail', 'smtp'], 'string', 'max' => 200],
            [['clave'], 'string', 'max' => 100],
            [['header'], 'string', 'max' => 1000],
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
            'mail' => 'Mail',
            'clave' => 'Clave',
            'smtp' => 'Smtp',
            'header' => 'Header',
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

    /**
     * Gets query for [[TemplateDependencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateDependencias()
    {
        return $this->hasMany(TemplateDependencia::className(), ['idDependencia' => 'idDependecia']);
    }

    /**
     * Gets query for [[UsuarioDependencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDependencias()
    {
        return $this->hasMany(UsuarioDependencia::className(), ['idDependencia' => 'idDependecia']);
    }
}
