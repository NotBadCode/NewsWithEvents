<?php

use yii\db\Migration;
use app\models\TriggeredEvent;

/**
 * Handles the creation of table `triggered_event_user`.
 */
class m170806_105020_create_triggered_event_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%triggered_event_user}}',
                           [
                               'id'                 => $this->primaryKey(),
                               'triggered_event_id' => $this->integer()->notNull(),
                               'user_id'            => $this->integer()->notNull(),
                               'status'             => $this->integer()
                                                            ->notNull()
                                                            ->defaultValue(TriggeredEvent::STATUS_VIEWED),
                           ]);

        $this->addForeignKey('fk_triggered_event_user_event',
                             '{{%triggered_event_user}}',
                             'triggered_event_id',
                             '{{%triggered_event}}',
                             'id',
                             'CASCADE',
                             'RESTRICT');

        $this->addForeignKey('fk_triggered_event_user_user',
                             '{{%triggered_event_user}}',
                             'user_id',
                             \dektrium\user\models\User::tableName(),
                             'id',
                             'CASCADE',
                             'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_triggered_event_user_user', '{{%triggered_event_user}}');
        $this->dropForeignKey('fk_triggered_event_user_event', '{{%triggered_event_user}}');
        $this->dropTable('{{%triggered_event_user}}');
    }
}