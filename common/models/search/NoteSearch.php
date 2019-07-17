<?php

namespace common\models\search;

use common\classes\Debug;
use common\models\Note;
use common\models\User;
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
        $queryNote = Note::find();
        $result = $this->getUserByParams($params);

        if ($result !== null && !empty($result)) {
            $queryNote->andFilterWhere(['in', 'authorId', $result]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $queryNote,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        return $dataProvider;
    }

    public function loadParams($data = [])
    {
        foreach ((array)$data as $key => $v) {
            if ($this->hasProperty($key)) {
                $this->{$key} = $v;
            }
        }
    }

    public function getUserByParams($params)
    {
        if(empty($params)) return null;
        $ids = [];
        $fl = 0;
        $queryUser = User::find();

        foreach ($params as $key => $v) {
            if ($this->hasProperty($key)) {
                $queryUser->andFilterWhere(['like', $key, $v]);
                $fl = 1;
            }
        }
        if($fl == 0) return null;
        $result = $queryUser->all();

        foreach ($result as $value) {
            $ids[] = (string) $value->_id;
        }

        return $ids;
    }
}