<?php

use common\migrations\db\Migration;

/**
 * Handles the creation of table `round`.
 */
class m210107_183501_create_round_table extends Migration
{

    private $_tableName_game = '{{%game}}';
    private $_tableName_round = '{{%round}}';

    private $_fkName_roundGameId_game = 'fk-round-gameId-user-id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->_tableName_round, [
            'id' => $this->primaryKey(),
            'gameId'=>$this->integer()->notNull(),
            'roundNumber'=>$this->integer()->notNull(),
            'firstUserScore'=>$this->integer(),
            'secondUserScore'=>$this->integer(),
            'startDate'=>$this->integer(),
            'gameConfiguration'=>$this->string()->notNull(),
            'roundSentence'=>$this->string(),
            'isFinished'=>$this->boolean(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey($this->_fkName_roundGameId_game, $this->_tableName_round, 'gameId', $this->_tableName_game, 'id','CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey($this->_fkName_roundGameId_game, $this->_tableName_round);
        $this->dropTable($this->_tableName_round);
    }
}
