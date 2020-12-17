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
 * @property string|null $legajo
 * @property int $idDependencia
 * 
 * @property Certificado[] $certificados
 * @property Usuario $idUsuario0
 * @property Ciudad $idCiudad0
 * @property Dependencia $idDependencia0

 */
class Persona extends \yii\db\ActiveRecord {

    public function validate($attributeNames = null, $clearErrors = true) {
        if ($this->mail == '') {
            $this->mail = null;
        }
        return parent::validate($attributeNames, $clearErrors);
    }

    /*
     * todo: Reescribir find() para que filtre solo las personas de las dependencias que tiene permisos
     */

    static function find() {

        $query = parent::find()->addSelect('*');
        if (!\Yii::$app->user->isGuest) {
            $in = \yii\helpers\ArrayHelper::getColumn(\app\models\Dependencia::find()->joinWith('usuarioDependencias')->where(['idUsuario' => \Yii::$app->user->identity->idUsuario])->all(), 'idDependecia');
            $in = '(' . implode(',', $in) . ')';

            $query->andWhere('persona.idDependencia in ' . $in);
        }
        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idUsuario', 'dni', 'idCiudad', 'idDependencia'], 'integer'],
            [['dni', 'idDependencia', 'apellidoNombre'], 'required'],
            [['apellidoNombre', 'mail'], 'string', 'max' => 100],
            [['legajo'], 'string', 'max' => 20],
            [['token'], 'string', 'max' => 32],
            [['telefono'], 'string', 'max' => 30],
            [['localidad'], 'string', 'max' => 100],
            [['Comentario'], 'string', 'max' => 347],
            /**
             * restricciones únicas asociadas a idDependencia
             */
            [['legajo'], 'unique', 'targetAttribute' => ['idDependencia', 'legajo']],
            [['dni'], 'unique', 'targetAttribute' => ['idDependencia', 'dni']],
            [['mail'], 'unique', 'targetAttribute' => ['idDependencia', 'mail']],
            [['mail'], 'email'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['idCiudad' => 'idCiudad']],
            [['idDependencia'], 'exist', 'skipOnError' => true, 'targetClass' => Dependencia::className(), 'targetAttribute' => ['idDependencia' => 'idDependecia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
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
            'legajo' => 'Legajo',
            'idDependencia' => 'Dependencia'
        ];
    }

    /**
     * Gets query for [[Certificados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificados() {
        return $this->hasMany(Certificado::className(), ['idPersona' => 'idPersona']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0() {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[IdCiudad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCiudad0() {
        return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
    }

    /**
     * Gets query for [[IdCiudad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdDependencia0() {
        return $this->hasOne(Dependencia::className(), ['idDependecia' => 'idDependencia']);
    }

}
