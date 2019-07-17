<?php

namespace common\models\search;

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
//        $query->leftJoin('user','user._id=note.authorId');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
//        Debug::prn($this->email);
        $query->andFilterWhere(['user.email' => $this->email]);
//        $query->andWhere(['=', 'authorId' , $this->authorId]);
        Debug::dd($query->andFilterCompare());
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