<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%treasure}}`.
 */
class m201026_122538_add_weight_column_to_treasure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%treasure}}', 'weight', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%treasure}}', 'weight');
    }
}
