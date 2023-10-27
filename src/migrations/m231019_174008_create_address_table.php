<?php

namespace ser6io\yii2contacts\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m231019_174008_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer(),
            'organization_id' => $this->integer(),
            'type' => $this->integer()->notNull()->defaultValue(0),
            'line_1' => $this->string(255)->notNull(),
            'line_2' => $this->string(255),
            'city' => $this->string(255)->notNull(),
            'state' => $this->string(255)->notNull(),
            'zip' => $this->string(255),
            'country' => $this->string(2)->notNull()->defaultValue('US'),
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
        $this->dropTable('{{%address}}');
    }
}
