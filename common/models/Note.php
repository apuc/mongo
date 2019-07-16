<?php

namespace common\models;

use yii\mongodb\ActiveRecord;

class Note extends ActiveRecord
{
    public static function collectionName()
    {
        return 'note';
    }

    public function attributes()
    {
        return ['_id', 'name', 'description', 'authorId', 'createdAt', 'updatedAt'];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['_id' => 'authorId']);
    }

    public function fields()
    {
        return [
            '_id',
            'name',
            'description',
            'authorId',
            'createdAt',
            'user',
        ];
    }
}