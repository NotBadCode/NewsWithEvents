<?php

use yii\db\Migration;
use app\models\Profile;

/**
 * Handles adding notify_type to table `profile`.
 */
class m170806_114105_add_notify_type_column_to_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(Profile::tableName(),
                         'notify_type',
                         $this->integer()->notNull()->defaultValue(Profile::NOTIFY_TYPE_ALL));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn(Profile::tableName(),
                          'notify_type');
    }
}