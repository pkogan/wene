<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lote;

/**
 * LoteSearch represents the model behind the search form of `app\models\Lote`.
 */
class LoteSearch extends Lote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idLote', 'idActividad', 'idEstado', 'idTipoCertificado', 'idTemplate'], 'integer'],
            [['fechaEmision', 'observacion'], 'safe'],
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
        $query = Lote::find();

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
            'idLote' => $this->idLote,
            'idActividad' => $this->idActividad,
            'idEstado' => $this->idEstado,
            'idTipoCertificado' => $this->idTipoCertificado,
            'idTemplate' => $this->idTemplate,
            'fechaEmision' => $this->fechaEmision,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
