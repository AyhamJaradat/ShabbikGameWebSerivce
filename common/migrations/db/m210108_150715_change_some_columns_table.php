<?php

use yii\db\Migration;

/**
 * Class m210108_150715_change_some_columns_table
 */
class m210108_150715_change_some_columns_table extends Migration
{

    private $_tableName_round = '{{%round}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->_tableName_round, 'gameConfiguration',$this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210108_150715_change_some_columns_table cannot be reverted.\n";

        return false;
    }
    */
}
