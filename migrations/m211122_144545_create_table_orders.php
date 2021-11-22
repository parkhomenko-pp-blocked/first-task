<?php

use yii\db\Migration;

class m211122_144545_create_table_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%orders}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'link' => $this->string(300)->notNull(),
                'quantity' => $this->integer()->notNull(),
                'service_id' => $this->integer()->notNull(),
                'status' => $this->boolean()->notNull()->comment('0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail'),
                'created_at' => $this->integer()->notNull(),
                'mode' => $this->boolean()->notNull()->comment('0 - Manual, 1 - Auto'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
