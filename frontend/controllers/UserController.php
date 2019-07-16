<?php

namespace frontend\controllers;

use common\classes\Debug;
use common\models\User;
use Faker\Factory;
use Yii;
use yii\mongodb\Query;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionCreateFakeUser($count)
    {
        $faker = Factory::create();
        for($i = 0; $i < $count; ++$i)
        {
            $collection = Yii::$app->mongodb->getCollection('user');
            $collection->insert([
                'email' => $faker->email,
                'firstName' => $faker->name,
                'lastName' => $faker->lastName,
                'createdAt' => strtotime($faker->date('d-m-Y')),
                'updatedAt' => strtotime($faker->date('d-m-Y')),
            ]);
        }

        return "Сгенерировано " . $count . " пользователей";
    }
}