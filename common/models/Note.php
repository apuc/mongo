<?php

namespace common\models;

use common\classes\Debug;
use Faker\Factory;
use Yii;
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
            'createdAt',
            'user',
        ];
    }

    public static function CreateNote($params)
    {
        $faker = Factory::create();
        $collection = Yii::$app->mongodb->getCollection('note');
        $collection->insert([
              'name' => $params['name'],
              'description' => $params['description'],
//            'name' => function ($params['name'], $faker){
//            $name = $params['name'] ? $params['name'] : $faker->department(3);
//            return $name;
//            },
//            'description' => function($params['description'], $faker) {
//            $description = $params['description'] ? $params['description'] :  $faker->text;
//            return $description;
//            },
            'authorId' => User::getRandomUser(),
            'createdAt' => strtotime($faker->date('d-m-Y')),
            'updatedAt' => strtotime($faker->date('d-m-Y')),
        ]);

        return "Добавлена новая заметка";
    }
}