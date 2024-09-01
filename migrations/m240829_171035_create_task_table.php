<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m240829_171035_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'status' => $this->string()->notNull(),
            'maturity' => $this->date()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'user_id' => $this->integer()->notNull(),
        ]);

        // Create index for column `user_id`
        $this->createIndex(
            'idx-task-user_id',
            'task',
            'user_id'
        );

        // Add foreign key for table `user`
        $this->addForeignKey(
            'fk-task-user_id',
            'task',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key for table `user`
        $this->dropForeignKey(
            'fk-task-user_id',
            'task'
        );

        // Drop index for column `user_id`
        $this->dropIndex(
            'idx-task-user_id',
            'task'
        );
        
        $this->dropTable('{{%task}}');
    }
}
