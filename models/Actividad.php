<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $idActividad
 * @property int $idTipoActividad
 * @property int $idDependencia
 * @property int|null $idActividadPadre
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property string|null $norma
 * @property int|null $idCiudad
 * @property int|null $duracion
 * @property string|null $medidaDuracion
 * @property string|null $observaciones
 *
 * @property Actividad $idActividadPadre0
 * @property Actividad[] $actividads
 * @property Dependencia $idDependencia0
 * @property TipoActividad $idTipoActividad0
 * @property Ciudad $idCiudad0
 * @property Lote[] $lotes
 */
class Actividad extends \yii\db\ActiveRecord {

    public $idProvincia;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['idTipoActividad', 'idDependencia', 'nombre', 'descripcion', 'fecha'], 'required'],
                [['idTipoActividad', 'idDependencia', 'idActividadPadre', 'idCiudad', 'duracion'], 'integer'],
                [['descripcion', 'observaciones', 'medidaDuracion'], 'string'],
                [['fecha'], 'safe'],
                [['nombre'], 'string', 'max' => 300],
                [['norma'], 'string', 'max' => 100],
                [['idActividadPadre'], 'exist', 'skipOnError' => true, 'targetClass' => Actividad::className(), 'targetAttribute' => ['idActividadPadre' => 'idActividad']],
                [['idDependencia'], 'exist', 'skipOnError' => true, 'targetClass' => Dependencia::className(), 'targetAttribute' => ['idDependencia' => 'idDependecia']],
                [['idTipoActividad'], 'exist', 'skipOnError' => true, 'targetClass' => TipoActividad::className(), 'targetAttribute' => ['idTipoActividad' => 'idTipo']],
                [['idCiudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['idCiudad' => 'idCiudad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idActividad' => 'Id Actividad',
            'idTipoActividad' => 'Tipo Actividad',
            'idDependencia' => 'Dependencia',
            'idActividadPadre' => 'Actividad Padre',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'observaciones' => 'Observación',
            'fecha' => 'Fecha',
            'norma' => 'Norma',
            'idCiudad' => 'Ciudad',
            'duracion' => 'Duracion',
            'medidaDuracion' => 'Medida duracion',
        ];
    }

    /**
     * Gets query for [[IdActividadPadre0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdActividadPadre0() {
        return $this->hasOne(Actividad::className(), ['idActividad' => 'idActividadPadre']);
    }

    /**
     * Gets query for [[Actividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividads() {
        return $this->hasMany(Actividad::className(), ['idActividadPadre' => 'idActividad']);
    }

    /**
     * Gets query for [[IdDependencia0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdDependencia0() {
        return $this->hasOne(Dependencia::className(), ['idDependecia' => 'idDependencia']);
    }

    /**
     * Gets query for [[IdTipoActividad0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoActividad0() {
        return $this->hasOne(TipoActividad::className(), ['idTipo' => 'idTipoActividad']);
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
     * Gets query for [[Lotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLotes() {
        return $this->hasMany(Lote::className(), ['idActividad' => 'idActividad']);
    }

    public function getFechaTexto() {
        return DateSpanish::cadena($this->fecha);
    }

    public function validarPermisos() {
        foreach ($this->idDependencia0->usuarioDependencias as $usuarioDependencia) {
            if (\Yii::$app->user->identity->idUsuario == $usuarioDependencia->idUsuario)
                return true;
        }
        throw new \yii\web\NotFoundHttpException('Está intentando acceder a una actividad sobre la que no tiene permisos.');
    }

}
