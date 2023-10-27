<?php

namespace ser6io\yii2contacts\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization}}`.
 */
class m231019_213123_create_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'nickname' => $this->string(255)->unique()->notNull(),
            'full_name' => $this->string(255)->unique()->notNull(),
            'type' => $this->integer()->notNull()->defaultValue(0),
            'email' => $this->string(255),
            'website' => $this->string(255),
            'phone' => $this->string(255),
            'notes' => $this->text(),
            'metadata' => $this->json(),
            'contact_id' => $this->integer(),
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
        $this->dropTable('{{%organization}}');
    }
}
