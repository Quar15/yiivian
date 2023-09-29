<?php

use yii\db\Migration;

/**
 * Class m230929_161214_add_resource_type_column_to_building
 */
class m230929_161214_add_resource_type_column_to_building extends Migration
{

    private const BUILDING_TABLE_NAME = 'building';
    private const BUILDING_TYPE_TABLE_NAME = 'building_type';

    private const RESOURCE_TYPE_COLUMN_NAME = 'resource_type';
    private const SLOT_TYPE_COLUMN_NAME = 'slot_type';
    private const LEVEL_COLUMN_NAME = 'level';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::BUILDING_TABLE_NAME, self::RESOURCE_TYPE_COLUMN_NAME, $this->smallInteger()->defaultValue(-1)->notNull());
        $this->addColumn(self::BUILDING_TYPE_TABLE_NAME, self::RESOURCE_TYPE_COLUMN_NAME, $this->smallInteger()->defaultValue(-1)->notNull());
        $this->addColumn(self::BUILDING_TABLE_NAME, self::SLOT_TYPE_COLUMN_NAME, $this->smallInteger()->defaultValue(1)->notNull());
        $this->addColumn(self::BUILDING_TABLE_NAME, self::LEVEL_COLUMN_NAME, $this->smallInteger()->defaultValue(1)->notNull());
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::BUILDING_TABLE_NAME, self::RESOURCE_TYPE_COLUMN_NAME);
        $this->dropColumn(self::BUILDING_TYPE_TABLE_NAME, self::RESOURCE_TYPE_COLUMN_NAME);
        $this->dropColumn(self::BUILDING_TABLE_NAME, self::SLOT_TYPE_COLUMN_NAME);
        $this->dropColumn(self::BUILDING_TABLE_NAME, self::LEVEL_COLUMN_NAME);
        return true;
    }
}
