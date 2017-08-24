<?php

use yii\db\Migration;

class m170804_021049_wx_log extends Migration
{
	public $logTableName = 'wx_log_gateway';
	
    public function safeUp()
    {
		if ($this->db->driverName === 'mysql') {
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->logTableName, [
                'id' => $this->bigPrimaryKey(),
                'type' => $this->string(),
                'get_data' => $this->text(),
                'post_data' => $this->text(),
            		'return_xml' => $this->text(),
            		'create_time' => $this->dateTime()
            ], $tableOptions);

            $this->createIndex('idx_wx_log_type', $this->logTableName, 'type');
    }

    public function safeDown()
    {
		$this->dropTable($this->logTableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170804_021048_wx_log cannot be reverted.\n";

        return false;
    }
    */
}
