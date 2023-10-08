<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m231008_153137_create_queue_table extends Migration
{
    private const USER_TABLE_NAME = 'user';
    private const USER_FIELD_ID = 'id';

    private const QUEUE_TABLE_NAME = 'queue';
    private const QUEUE_FIELD_ID = 'id';
    private const QUEUE_FIELD_USER_ID = 'user_id';
    private const QUEUE_FIELD_QUEUE_TYPE = 'queue_type';
    private const QUEUE_FIELD_EXECUTION_TIMESTAMP = 'execution_timestamp';
    private const QUEUE_FIELD_COMMAND = 'command';
    private const QUEUE_FIELD_IS_PROCESSED = 'is_processed';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::QUEUE_TABLE_NAME, [
            self::QUEUE_FIELD_ID => $this->primaryKey(),
            self::QUEUE_FIELD_USER_ID => $this->integer()->notNull(),
            self::QUEUE_FIELD_QUEUE_TYPE => $this->tinyInteger()->notNull(),
            self::QUEUE_FIELD_EXECUTION_TIMESTAMP => $this->timestamp()->notNull()->defaultExpression('NOW()'),
            self::QUEUE_FIELD_COMMAND => $this->string()->notNull(),
            self::QUEUE_FIELD_IS_PROCESSED => $this->boolean()->notNull()->defaultValue(false)
        ]);

        $this->addForeignKey(
            self::QUEUE_TABLE_NAME . '_' . self::QUEUE_FIELD_USER_ID . '_fk',
            self::QUEUE_TABLE_NAME, self::QUEUE_FIELD_USER_ID,
            self::USER_TABLE_NAME, self::USER_FIELD_ID
        );

        $this->createIndex(
            self::QUEUE_TABLE_NAME . '_' . self::QUEUE_FIELD_USER_ID . '_idx',
            self::QUEUE_TABLE_NAME, self::QUEUE_FIELD_USER_ID
        );

        $this->db
            ->createCommand(
                'CREATE UNIQUE INDEX "' . self::QUEUE_TABLE_NAME . '_' . self::QUEUE_FIELD_USER_ID . '_' . self::QUEUE_FIELD_QUEUE_TYPE . '_' . self::QUEUE_FIELD_COMMAND . '_' . self::QUEUE_FIELD_IS_PROCESSED . '_uidx" ' .
                'ON "' . self::QUEUE_TABLE_NAME . '" ' .
                '(' . self::QUEUE_FIELD_USER_ID . ',' . self::QUEUE_FIELD_QUEUE_TYPE . ',' . self::QUEUE_FIELD_COMMAND . ',' . self::QUEUE_FIELD_IS_PROCESSED . ') ' .  
                'WHERE ' . self::QUEUE_FIELD_IS_PROCESSED . ' = true;'
            )->execute();
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::QUEUE_TABLE_NAME);
    }
}
