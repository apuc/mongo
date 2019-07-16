<?php

class m190716_123638_create_note_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('note');
    }

    public function down()
    {
        $this->dropCollection('note');
    }
}
