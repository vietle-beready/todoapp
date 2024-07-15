<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240711_084437_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string(),
            'authKey' => $this->string(32),
            'accessToken' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            // 'created_at' => $this->integer()->notNull(),
            // 'updated_at' => $this->integer()->notNull(),
        ]);


        $this->createIndex(
            'idx-user-email',
            'user',
            'email'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
