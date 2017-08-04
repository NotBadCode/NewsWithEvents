<?php

use yii\db\Migration;

/**
 * Handles adding user_id to table `news`.
 */
class m170804_104956_add_user_id_column_to_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'user_id', $this->integer()->notNull());

        $this->addForeignKey('news_user',
                             '{{%news}}',
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
        $this->dropForeignKey('news_user', '{{%news}}');
        $this->dropColumn('{{%news}}', 'user_id');
    }
}
