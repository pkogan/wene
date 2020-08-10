<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property int $idTemplate
 * @property string $template
 * @property string $orientacion
 *
 * @property Lote[] $lotes
 */
class Template extends \yii\db\ActiveRecord
{
    const ADJUNTO=6;
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
            [['template','orientacion'], 'required'],
            [['template'], 'string', 'max' => 50],
            [['orientacion'], 'string', 'max' => 1],
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
            'orientacion' => 'Orientacion',

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
