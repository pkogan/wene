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
    public $actividad;
    public $dependencia;
    public $idTipoCertificado;
    public $idTipoActividad;
    public $dealerAvailableDate;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idCertificado', 'idPersona','dni', 'idLote', 'idEstado', 'observacion', 'idTipoCertificado', 'idTipoActividad'], 'integer'],
            [['hash','apellidoNombre','estado','mail','actividad','dependencia','dealerAvailableDate'], 'safe'],
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
        
        
        $query->joinWith('idPersona0')->joinWith('idLote0.idActividad0.idDependencia0.usuarioDependencias');
        $query->where(['usuarioDependencia.idUsuario'=> \Yii::$app->user->identity->idUsuario]);
        

        // grid filtering conditions
        $query->andFilterWhere([
            'idCertificado' => $this->idCertificado,
            'idPersona' => $this->idPersona,
            'certificado.idLote' => $this->idLote,
            'idEstado' => $this->idEstado,
            //'observacion' => $this->observacion,
            'persona.dni' => $this->dni,
            'lote.idTipoCertificado'=> $this->idTipoCertificado,
            'actividad.idTipoActividad'=> $this->idTipoActividad
          
        ]);

        $query->andFilterWhere(['like', 'hash', $this->hash])
              ->andFilterWhere(['like','persona.apellidoNombre', $this->apellidoNombre])
                ->andFilterWhere(['like','persona.mail', $this->mail])
                ->andFilterWhere(['like','actividad.nombre', $this->actividad])
                ->andFilterWhere(['like','dependencia.nombre', $this->dependencia])
                ;
        
        $dataProvider->sort->attributes['apellidoNombre'] = [
            'asc' => ['persona.apellidoNombre' => SORT_ASC],
            'desc' => ['persona.apellidoNombre' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['mail'] = [
            'asc' => ['persona.mail' => SORT_ASC],
            'desc' => ['persona.mail' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['dealerAvailableDate'] = [
            'asc' => ['lote.fechaEmision' => SORT_ASC],
            'desc' => ['lote.fechaEmision' => SORT_DESC],
        ];
        
        if (isset($this->dealerAvailableDate) && $this->dealerAvailableDate != '') { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->dealerAvailableDate);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'lote.fechaEmision', $date1, $date2]);
        }
        
        return $dataProvider;
    }
}
