<?php

namespace ser6io\yii2contacts\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m231205_054607_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'nickname' => $this->string(255),
            'website' => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(255),
            'mobile' => $this->string(255),
            'notes' => $this->text(),
            'metadata' => $this->json(),
           
            'type' => $this->integer()->notNull()->defaultValue(0),
            'sub_type' => $this->integer()->notNull()->defaultValue(0),

            'organization_id' => $this->integer(),
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
        $this->dropTable('{{%contact}}');
    }
}
