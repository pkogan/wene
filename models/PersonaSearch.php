<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Persona;

/**
 * PersonaSearch represents the model behind the search form of `app\models\Persona`.
 */
class PersonaSearch extends Persona
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPersona', 'idUsuario', 'dni', 'idCiudad'], 'integer'],
            [['mail', 'apellidoNombre', 'telefono', 'localidad', 'Comentario', 'token', 'legajo', 'idDependencia', 'idExtranjero'], 'safe'],
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
        $query = Persona::find();

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
            'idPersona' => $this->idPersona,
            'idUsuario' => $this->idUsuario,
            'dni' => $this->dni,
            'idCiudad' => $this->idCiudad,
            'idDependencia' => $this->idDependencia,
        ]);

        $query->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'apellidoNombre', $this->apellidoNombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'localidad', $this->localidad])
            ->andFilterWhere(['like', 'Comentario', $this->Comentario])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'legajo', $this->legajo]);

        return $dataProvider;
    }
}
