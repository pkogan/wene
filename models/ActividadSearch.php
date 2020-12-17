<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividad;

/**
 * ActividadSearch represents the model behind the search form of `app\models\Actividad`.
 */
class ActividadSearch extends Actividad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idActividad', 'idTipoActividad', 'idDependencia', 'idActividadPadre', 'idCiudad', 'duracion'], 'integer'],
            [['nombre', 'descripcion', 'fecha', 'norma', 'observaciones'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Actividad::find();
        $query->joinWith('idDependencia0.usuarioDependencias');
        $query->where(['usuarioDependencia.idUsuario'=> \Yii::$app->user->identity->idUsuario]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idActividad' => $this->idActividad,
            'idTipoActividad' => $this->idTipoActividad,
            'actividad.idDependencia' => $this->idDependencia,
            'idActividadPadre' => $this->idActividadPadre,
            'fecha' => $this->fecha,
            'idCiudad' => $this->idCiudad,
            'duracion' => $this->duracion,
        ]);

        $query->andFilterWhere(['like', 'actividad.nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'norma', $this->norma])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
