<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Task
{
    public $filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'status', 'is_deleted'], 'integer'],
            [['description'], 'safe'],
            [['filter'], 'string']
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
        $query = Task::find();

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

        $query->andFilterWhere([
            'like', 'description', $this->description
        ])->andFilterWhere([
            'is_deleted' => false,
            'id_user' => Yii::$app->user->identity->id
        ]);

        return $dataProvider;
    }

    public function filter($params)
    {
        $query = Task::find();

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
        $filter = $this->filter;

        $query->andFilterWhere([
            'is_deleted' => false,
            'id_user' => Yii::$app->user->identity->id
        ]);

        if ($filter === 'all') {
            $query->andFilterWhere(['status' => [0, 1]]);
        } else if ($filter === 'complete') {
            $query->andFilterWhere(['status' => 1]);
        } else {
            $query->andFilterWhere(['status' => 0]);
        }

        return $dataProvider;
    }
}
