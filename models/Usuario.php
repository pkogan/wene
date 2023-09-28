<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $idUsuario
 * @property string $nombreUsuario
 * @property string $clave
 * @property int $idRol
 *
 * @property Persona[] $personas
 * @property Rol $idRol0
 * @property UsuarioDependencia[] $usuarioDependencias 
 */
//class Usuario extends \yii\db\ActiveRecord
//{
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    /**************************************************/
    private $username;

    public function getUsername() {
        return $this->nombreUsuario;
    }

    public static function findByUsername($username) {
        return self::findOne(['nombreUsuario' => $username]);
    }

    public function beforeSave($insert)
    {
        $this->clave = Yii::$app->security->generatePasswordHash($this->clave);

        return parent::beforeSave($insert);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->clave);
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId() {
        return $this->idUsuario;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey() {
        return $this->idUsuario;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    
    /*     * ******************************************************* */
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombreUsuario', 'clave', 'idRol'], 'required'],
            [['idRol'], 'integer'],
            [['nombreUsuario', 'clave'], 'string', 'max' => 100],
            [['nombreUsuario'], 'unique'],
            [['idRol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['idRol' => 'idRol']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'nombreUsuario' => 'Nombre Usuario',
            'clave' => 'Clave',
            'idRol' => 'Id Rol',
        ];
    }

    /**
     * Gets query for [[Personas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[IdRol0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdRol0()
    {
        return $this->hasOne(Rol::className(), ['idRol' => 'idRol']);
    }
    
    /** 
    * Gets query for [[UsuarioDependencias]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getUsuarioDependencias() 
   { 
       return $this->hasMany(UsuarioDependencia::className(), ['idUsuario' => 'idUsuario']); 
   } 
   
   public function getDependenciasIn(){
       
   }
}
