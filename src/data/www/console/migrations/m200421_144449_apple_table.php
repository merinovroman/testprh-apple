<?php

use yii\db\Migration;

/**
 * Class m200421_144449_apple_table
 *
 * @author Roman Merinov <merinovroman@gmail.com>
 */
class m200421_144449_apple_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(50),
            'created_at' => $this->integer(),
            'fall_at' => $this->integer(),
            'status' => 'ENUM("hanging","fall","rotten") DEFAULT "hanging"',
            'size' => $this->decimal(3, 2)
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%apple}}');

        return true;
    }
}
