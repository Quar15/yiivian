<?php

use yii\db\Migration;

/**
 * Class m230930_114555_add_building_type_info_to_building_table
 */
class m230930_114555_add_building_type_info_to_building_table extends Migration
{
    private const BUILDING_TABLE_NAME = 'building';
    private const BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME = 'building_type_info_id';

    private const BUILDING_TYPE_INFO_TABLE_NAME = 'building_type_info';
    private const BUILDING_TYPE_INFO_TABLE_ID_COLUMN_NAME = 'id';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::BUILDING_TABLE_NAME, self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME, $this->smallInteger());
        $this->update(
            self::BUILDING_TABLE_NAME,
            [self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME => 0]
        );
        $this->alterColumn(
            self::BUILDING_TABLE_NAME, 
            self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME, 
            $this->smallInteger()->notNull()
        );
        $this->addForeignKey(
            self::BUILDING_TABLE_NAME . '_' . self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME . '_fk',
            self::BUILDING_TABLE_NAME, self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME,
            self::BUILDING_TYPE_INFO_TABLE_NAME, self::BUILDING_TYPE_INFO_TABLE_ID_COLUMN_NAME,
            'SET NULL',
            'CASCADE'
        );
        $this->createIndex(
            self::BUILDING_TABLE_NAME . '_' . self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME . '_idx',
            self::BUILDING_TABLE_NAME, self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(
            self::BUILDING_TABLE_NAME, 
            self::BUILDING_TABLE_BUILDING_TYPE_INFO_ID_COLUMN_NAME,
        );
    }
}
