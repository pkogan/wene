<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Certificado;

/**
 * CertificadoSearch represents the model behind the search form of `app\models\Certificado`.
 */
class CertificadoSearch extends Certificado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idCertificado', 'idPersona', 'idLote', 'idEstado', 'observacion'], 'integer'],
            [['hash'], 'safe'],
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
        $query = Certificado::find();

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
            'idCertificado' => $this->idCertificado,
            'idPersona' => $this->idPersona,
            'idLote' => $this->idLote,
            'idEstado' => $this->idEstado,
            'observacion' => $this->observacion,
        ]);

        $query->andFilterWhere(['like', 'hash', $this->hash]);

        return $dataProvider;
    }
}
