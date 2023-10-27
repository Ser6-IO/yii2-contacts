<?php

namespace ser6io\yii2contacts\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%person}}`.
 */
class m231019_211933_create_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%person}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->unique()->notNull(),
            'phone' => $this->string(255),
            'mobile' => $this->string(255),
            'notes' => $this->text(),
            'metadata' => $this->json(),
            'organization_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'isDeleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%person}}');
    }
}
