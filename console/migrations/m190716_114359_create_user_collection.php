<?php

class m190716_114359_create_user_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('user');
    }

    public function down()
    {
       $this->dropCollection('user');
    }
}
