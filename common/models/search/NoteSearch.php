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

}