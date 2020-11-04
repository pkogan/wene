<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoCertificado;

/**
 * TipoCertificadoSearch represents the model behind the search form of `app\models\TipoCertificado`.
 */
class TipoCertificadoSearch extends TipoCertificado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTipoCertificado'], 'integer'],
            [['tipo', 'conectorM', 'conectorF'], 'safe'],
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
        $query = TipoCertificado::find();

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
            'idTipoCertificado' => $this->idTipoCertificado,
        ]);

        $query->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'conectorM', $this->conectorM])
            ->andFilterWhere(['like', 'conectorF', $this->conectorF]);

        return $dataProvider;
    }
}
