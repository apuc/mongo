<?php

namespace frontend\controllers;

use common\classes\Debug;
use common\models\Note;
use common\models\search\NoteSearch;
use common\models\User;
use Faker\Factory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class NoteController extends ActiveController
{
    public $modelClass = 'common\models\Note';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['index']);
        // customize the data provider preparation with the "prepareDataProvider()" method
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        return new ActiveDataProvider([
            'query' => Note::find()->limit(1),
        ]);
    }

    public function actionCreateFakerNote($count)
    {
        $faker = Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        for($i = 0; $i < $count; ++$i)
        {
            $collection = Yii::$app->mongodb->getCollection('note');
            $collection->insert([
                'name' => $faker->department(3),
                'description' => $faker->text,
                'authorId' => User::getRandomUser(),
                'createdAt' => strtotime($faker->date('d-m-Y')),
                'updatedAt' => strtotime($faker->date('d-m-Y')),
            ]);
        }

        return "Добавлено " . $count . " заметок";
    }

    public function actionIndex()
    {
        $search = new NoteSearch();
        $search->loadParams(Yii::$app->request->get());

        return $search->search(Yii::$app->request->queryParams);
    }
}