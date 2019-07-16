<?php

namespace common\models;

use common\classes\Debug;
use Yii;
use yii\mongodb\ActiveRecord;

class User extends ActiveRecord
{
    public static function collectionName()
    {
        return 'user';
    }

    public function attributes()
    {
        return ['_id', 'email', 'firstName', 'lastName', 'createdAt', 'updatedAt'];
    }

    public function fields()
    {
        return [
            '_id',
           'email',
            'firstName',
            'lastName',
            'createdAt'
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->createdAt = date('Y-d-mTG:i:sz', $this->createdAt);
    }

    public static function getRandomUser()
    {
        $collection = Yii::$app->mongodb->getCollection('user');
        $limit = 1;
        $skip = rand(0, $collection->count());
        $skip = $skip < 0 ? 0 : $skip;

        $model = self::find()->limit($limit)->offset($skip)->asArray()->one();
        return (string) $model['_id'];
    }
}