<?php

use common\migrations\db\Migration;

/**
 * Handles the creation of table `pull_notification`.
 */
class m210109_190625_create_pull_notification_table extends Migration
{

    private $_tableName_notification = '{{%pull_notification}}';
    private $_tableName_round = '{{%round}}';
    private $_tableName_user = '{{%user}}';

    private $_fkName_notif_roundId_round = 'fk-notification-roundId-round-id';
    /**
     * @var string
     */
    private $_fkName_notif_userId_user = 'fk-notification-userId-user-id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->_tableName_notification, [
            'id' => $this->primaryKey(),
            'roundId' =>$this->integer()->notNull(),
            'whoAmI'=>  $this->integer(),
            'userId'=>$this->integer()->notNull(),
            'notificationStatus'=>$this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey($this->_fkName_notif_roundId_round, $this->_tableName_notification, 'roundId', $this->_tableName_round, 'id','CASCADE', 'CASCADE');
        $this->addForeignKey($this->_fkName_notif_userId_user, $this->_tableName_notification, 'userId', $this->_tableName_user, 'id','CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey($this->_fkName_notif_userId_user, $this->_tableName_notification);
        $this->dropForeignKey($this->_fkName_notif_roundId_round, $this->_tableName_notification);
        $this->dropTable($this->_tableName_notification);
    }
}
