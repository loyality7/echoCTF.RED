<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%challenge}}`.
 */
class m201102_075616_add_timer_column_to_challenge_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%challenge}}', 'timer', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%challenge}}', 'timer');
    }
}
