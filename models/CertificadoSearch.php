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
    public $apellidoNombre;
    public $dni;
    public $estado;
    public $mail;
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idCertificado', 'idPersona','dni', 'idLote', 'idEstado', 'observacion'], 'integer'],
            [['hash','apellidoNombre','estado','mail'], 'safe'],
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
        
        
        $query->joinWith('idPersona0');

        // grid filtering conditions
        $query->andFilterWhere([
            'idCertificado' => $this->idCertificado,
            'idPersona' => $this->idPersona,
            'idLote' => $this->idLote,
            'idEstado' => $this->idEstado,
            //'observacion' => $this->observacion,
            'persona.dni' => $this->dni,
          
        ]);

        $query->andFilterWhere(['like', 'hash', $this->hash])
              ->andFilterWhere(['like','persona.apellidoNombre', $this->apellidoNombre])
                ->andFilterWhere(['like','persona.mail', $this->mail]) ;
        
        $dataProvider->sort->attributes['apellidoNombre'] = [
            'asc' => ['persona.apellidoNombre' => SORT_ASC],
            'desc' => ['persona.apellidoNombre' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['mail'] = [
            'asc' => ['persona.mail' => SORT_ASC],
            'desc' => ['persona.mail' => SORT_DESC],
        ];
        return $dataProvider;
    }
}
