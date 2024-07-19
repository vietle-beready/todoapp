<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m240716_062216_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        $this->addForeignKey(
            'fk-task-id_user',
            'task',
            'id_user',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task-description',
            'task',
            'description'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
