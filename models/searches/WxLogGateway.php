<?php

namespace kaikaige\wxgz\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kaikaige\wxgz\models\WxLogGateway as WxLogGatewayModel;

/**
 * WxLogGateway represents the model behind the search form of `kaikaige\wxgz\models\WxLogGateway`.
 */
class WxLogGateway extends WxLogGatewayModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['type', 'get_data', 'post_data', 'return_xml', 'create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = WxLogGatewayModel::find();

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
        
        $query->orderBy = [
        		'id' => SORT_DESC
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'get_data', $this->get_data])
            ->andFilterWhere(['like', 'post_data', $this->post_data])
            ->andFilterWhere(['like', 'return_xml', $this->return_xml]);

        return $dataProvider;
    }
}
