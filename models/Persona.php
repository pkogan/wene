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
 * @property string|null $idExtranjero
 * 
 * @property Certificado[] $certificados
 * @property Usuario $idUsuario0
 * @property Ciudad $idCiudad0
 * @property Dependencia $idDependencia0

 */
class Persona extends \yii\db\ActiveRecord {

    public function validate($attributeNames = null, $clearErrors = true) {
//        if ($this->mail == '') {
//            $this->mail = null;
//        }
//        if ($this->idExtranjero== '') {
//            $this->idExtranjero = null;
//        }
        return parent::validate($attributeNames, $clearErrors);
    }

    /*
     * todo: Reescribir find() para que filtre solo las personas de las dependencias que tiene permisos
     */

    static function find() {

        $query = parent::find()->addSelect('*');
        if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->idRol != Rol::ROL_CERTIFICANTE) {
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
            [[/* 'dni', */ 'idDependencia', 'apellidoNombre'], 'required'],
            [['apellidoNombre', 'mail'], 'string', 'max' => 100],
            [['legajo'], 'string', 'max' => 20],
            [['token'], 'string', 'max' => 32],
            [['telefono'], 'string', 'max' => 30],
            [['localidad'], 'string', 'max' => 100],
            [['Comentario'], 'string', 'max' => 347],
            [['idExtranjero'], 'string', 'max' => 50],
            /**
             * mail y idExtranjero se asignan null
             */
            [['mail', 'idExtranjero'], 'default'],
            /**
             * restricciones únicas asociadas a idDependencia
             */
            [['idExtranjero'], 'unique', 'targetAttribute' => ['idDependencia', 'idExtranjero']],
            [['legajo'], 'unique', 'targetAttribute' => ['idDependencia', 'legajo']],
            [['dni'], 'unique', 'targetAttribute' => ['idDependencia', 'dni']],
            [['mail'], 'unique', 'targetAttribute' => ['idDependencia', 'mail']],
            /**
             * dni o idextranjero tienen que estar
             */
            ['dni', 'required', 'when' => function ($model) {
                    return is_null($model->idExtranjero);
                },
                'whenClient' => "function (attribute, value) {
                    return $('#idExtranjero').val() == NULL;
                 }"
            ,'message' => 'dni e id externo no pueden estar vacios al mismo tiempo'],
            ['idExtranjero', 'required', 'when' => function ($model) {
                    return is_null($model->dni);
                },
                'whenClient' => "function (attribute, value) {
                    return $('#dni').val() == NULL;
                 }"
            ],
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
            'idDependencia' => 'Dependencia',
            'idExtranjero' => 'Id externo',
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

    /**
     * Devuelve el identificador de la persona
     * Si dni no es nul retorna dni
     * Si idExtranjero no es nulo y no comienza con 'SINDNI' retorno idExtranjero
     * Sino rentorna ''
     * 
     * @return string
     */
    public function getDnioIdext(){
        if($this->dni!=null){
            return 'DNI Nº <b>'. number_format($this->dni,0,',','.').'</b>';
        }elseif($this->idExtranjero!=null && substr($this->idExtranjero, 0, 6)!='SINDNI'){
            return '(<b>'. $this->idExtranjero.'</b>)';
        }else{
            return '';
        }
    }
    public function getApellidoNombreUcfirst( $encoding = 'UTF-8'){
        $string=$this->apellidoNombre;
        $salida_minuscula= mb_strtolower($string,$encoding);
        $anterior = mb_strtoupper(mb_substr($string, 0, 1, $encoding), $encoding);
        $salida=$anterior;
        for ($i=1; $i<strlen($salida_minuscula); $i++) { 
            if($anterior==" "){
                $anterior=mb_strtoupper(mb_substr($salida_minuscula, $i, 1, $encoding), $encoding);
                
            }else{
                $anterior=mb_substr($salida_minuscula, $i, 1, $encoding);
            }
            $salida.=$anterior;
        }
        
        return  $salida;
      }
}
