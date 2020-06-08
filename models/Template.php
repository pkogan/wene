<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property int $idTemplate
 * @property string $template
 *
 * @property Lote[] $lotes
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template'], 'required'],
            [['template'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idTemplate' => 'Id Template',
            'template' => 'Template',
        ];
    }

    /**
     * Gets query for [[Lotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLotes()
    {
        return $this->hasMany(Lote::className(), ['idTemplate' => 'idTemplate']);
    }
}
