<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templateDependencia".
 *
 * @property int $idTemplateDependencia
 * @property int $idTemplate
 * @property int $idDependencia
 *
 * @property Dependencia $idDependencia0
 * @property Template $idTemplate0
 */
class TemplateDependencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templateDependencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTemplate', 'idDependencia'], 'required'],
            [['idTemplate', 'idDependencia'], 'integer'],
            [['idDependencia'], 'exist', 'skipOnError' => true, 'targetClass' => Dependencia::className(), 'targetAttribute' => ['idDependencia' => 'idDependecia']],
            [['idTemplate'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['idTemplate' => 'idTemplate']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idTemplateDependencia' => 'Id Template Dependencia',
            'idTemplate' => 'Id Template',
            'idDependencia' => 'Id Dependencia',
        ];
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

    /**
     * Gets query for [[IdTemplate0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTemplate0()
    {
        return $this->hasOne(Template::className(), ['idTemplate' => 'idTemplate']);
    }
}
