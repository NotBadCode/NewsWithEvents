<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m170804_095610_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}',
                           [
                               'id'          => $this->primaryKey(),
                               'title'       => $this->string()->notNull(),
                               'slug'        => $this->string()->notNull(),
                               'image'       => $this->string(),
                               'status'      => $this->integer()->notNull(),
                               'short_text'  => $this->string(),
                               'text'        => $this->text()->notNull(),
                               'create_time' => $this->timestamp()->notNull(),
                               'update_time' => $this->timestamp()
                                                     ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
                                                     ->notNull()
                           ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
