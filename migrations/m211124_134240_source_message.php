<?php

use yii\db\Migration;

/**
 * Class m211124_134240_sourcemessage
 */
class m211124_134240_source_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('source_message', [
            'id' => 'INT(11) AUTO_INCREMENT',
            'category' => 'VARCHAR(32)',
            'message' => 'TEXT',
            'PRIMARY KEY (id)',
        ]);
        $this->createTable('message', [
            'id' => 'INT(11)',
            'language' => 'VARCHAR(16)',
            'translation' => 'TEXT',
            'PRIMARY KEY (id,language)',
        ]);

        $this->addForeignKey('fk_message_source_message', 'message', 'id', 'source_message', 'id','CASCADE','RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211124_134240_sourcemessage cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211124_134240_sourcemessage cannot be reverted.\n";

        return false;
    }
    */
}
