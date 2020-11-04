<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TemplateDependencia;

/**
 * TemplateDependenciaSearch represents the model behind the search form of `app\models\TemplateDependencia`.
 */
class TemplateDependenciaSearch extends TemplateDependencia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTemplateDependencia', 'idTemplate', 'idDependencia'], 'integer'],
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
        $query = TemplateDependencia::find();

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
            'idTemplateDependencia' => $this->idTemplateDependencia,
            'idTemplate' => $this->idTemplate,
            'idDependencia' => $this->idDependencia,
        ]);

        return $dataProvider;
    }
}
