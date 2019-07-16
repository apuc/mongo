<?php

namespace common\models\search;

use backend\modules\holiday\models\Holiday;
use common\classes\Debug;
use common\models\Note;
use yii\data\ActiveDataProvider;

class NoteSearch extends Note
{
    public $email;
    public $firstName;

    public function rules()
    {
        return [
            [['email', 'firstName', 'authorId'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Note::find()->with('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere(['like', 'user.email' , $this->email]);

        // grid filtering conditions
        return $dataProvider->getModels();
    }

    public function loadParams($data = [])
    {
        foreach ((array)$data as $key => $v) {
            if ($this->hasProperty($key)) {
                $this->{$key} = $v;
            }
        }
    }
}