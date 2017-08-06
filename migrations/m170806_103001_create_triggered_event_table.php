<?php

use yii\db\Migration;

/**
 * Handles the creation of table `triggered_event`.
 */
class m170806_103001_create_triggered_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%triggered_event}}',
                           [
                               'id'          => $this->primaryKey(),
                               'event'       => $this->string()->notNull(),
                               'sender'      => $this->string()->notNull(),
                               'sender_id'   => $this->integer()->notNull(),
                               'create_time' => $this->timestamp()->notNull(),
                           ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%triggered_event}}');
    }
}