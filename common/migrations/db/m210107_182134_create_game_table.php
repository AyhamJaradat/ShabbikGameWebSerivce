<?php

use common\migrations\db\Migration;

/**
 * Handles the creation of table `game`.
 */
class m210107_182134_create_game_table extends Migration
{

    private $_tableName_game = '{{%game}}';
    private $_tableName_user = '{{%user}}';

    private $_fkName_gameFirstUserID_user = 'fk-game-firstUserId-user-id';
    /**
     * @var string
     */
    private $_fkName_gameSeconUserId_user = 'fk-game-secondUserId-user-id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->_tableName_game, [
            'id' => $this->primaryKey(),
            'startDate' =>$this->integer(),
            'gameMode'=> $this->string()->notNull(),
            'firstUserId'=>$this->integer()->notNull(),
            'secondUserId'=>$this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey($this->_fkName_gameFirstUserID_user, $this->_tableName_game, 'firstUserId', $this->_tableName_user, 'id','CASCADE', 'CASCADE');
        $this->addForeignKey($this->_fkName_gameSeconUserId_user, $this->_tableName_game, 'secondUserId', $this->_tableName_user, 'id','CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey($this->_fkName_gameSeconUserId_user, $this->_tableName_game);
        $this->dropForeignKey($this->_fkName_gameFirstUserID_user, $this->_tableName_game);
        $this->dropTable($this->_tableName_game);
    }
}
