<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property int $idPersona
 * @property int|null $idUsuario
 * @property string|null $mail
 * @property int $dni
 * @property string|null $apellidoNombre
 * @property string|null $telefono
 * @property string|null $localidad
 * @property string|null $Comentario
 * @property int|null $idCiudad
 * @property string|null $token
 *
 * @property Certificado[] $certificados
 * @property Usuario $idUsuario0
 * @property Ciudad $idCiudad0
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'dni', 'idCiudad'], 'integer'],
            [['dni'], 'required'],
            [['apellidoNombre','mail'], 'string', 'max' => 100],
            [[ 'token'], 'string', 'max' => 32],
            [['telefono'], 'string', 'max' => 30],
            [['localidad'], 'string', 'max' => 100],
            [['Comentario'], 'string', 'max' => 347],
            [['dni'], 'unique'],
            [['mail'], 'unique'],
            [['mail'], 'email'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['idCiudad' => 'idCiudad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPersona' => 'Id Persona',
            'idUsuario' => 'Id Usuario',
            'mail' => 'Mail',
            'dni' => 'Dni',
            'apellidoNombre' => 'Apellido Nombre',
            'telefono' => 'Telefono',
            'localidad' => 'Localidad',
            'Comentario' => 'Comentario',
            'idCiudad' => 'Id Ciudad',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[Certificados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificados()
    {
        return $this->hasMany(Certificado::className(), ['idPersona' => 'idPersona']);
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
     * Gets query for [[IdCiudad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCiudad0()
    {
        return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
    }
}
