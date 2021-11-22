<?php

use yii\db\Migration;

class m211122_145230_create_table_services extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%services}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(300)->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%services}}');
    }
}
