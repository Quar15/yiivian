<?php

use yii\db\Migration;

/**
 * Class m231013_171037_add_primary_key_to_building_cost_and_village_resource
 */
class m231013_171037_add_primary_key_to_building_cost_and_village_resource extends Migration
{
    private const BUILDING_COST_TABLE_NAME = 'building_cost';
    private const BUILDING_COST_PK_NAME = self::BUILDING_COST_TABLE_NAME . '_pk';
    private const BUILDING_COST_FIELD_BUILDING_TYPE_ID = 'building_type_id';
    private const BUILDING_COST_FIELD_RESOURCE_TYPE = 'resource_type';

    private const VILLAGE_RESOURCE_TABLE_NAME = 'village_resource';
    private const VILLAGE_RESOURCE_PK_NAME = self::VILLAGE_RESOURCE_TABLE_NAME . '_pk';
    private const VILLAGE_RESOURCE_FIELD_VILLAGE_ID = 'village_id';
    private const VILLAGE_RESOURCE_FIELD_RESOURCE_TYPE = 'resource_type';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addPrimaryKey(
            self::BUILDING_COST_PK_NAME,
            self::BUILDING_COST_TABLE_NAME,
            [
                self::BUILDING_COST_FIELD_BUILDING_TYPE_ID,
                self::BUILDING_COST_FIELD_RESOURCE_TYPE
            ]
        );
        
        $this->addPrimaryKey(
            self::VILLAGE_RESOURCE_PK_NAME,
            self::VILLAGE_RESOURCE_TABLE_NAME,
            [
                self::VILLAGE_RESOURCE_FIELD_VILLAGE_ID,
                self::VILLAGE_RESOURCE_FIELD_RESOURCE_TYPE
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey(self::BUILDING_COST_PK_NAME, self::BUILDING_COST_TABLE_NAME);
        $this->dropPrimaryKey(self::VILLAGE_RESOURCE_PK_NAME, self::VILLAGE_RESOURCE_TABLE_NAME);
    }
}
