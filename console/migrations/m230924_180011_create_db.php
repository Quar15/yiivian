<?php

use yii\db\Migration;

/**
 * Class m230924_180011_create_db
 */
class m230924_180011_create_db extends Migration
{
    private const VILLAGE_TABLE_NAME = 'village';
    private const VILLAGE_TABLE_FIELD_ID = 'id';
    private const VILLAGE_TABLE_FIELD_NAME = 'name';
    private const VILLAGE_TABLE_FIELD_USER_ID = 'user_id';

    private const USER_TABLE_NAME = 'user';
    private const USER_TABLE_FIELD_ID = 'id';

    private const BUILDING_TABLE_NAME = 'building';
    private const BUILDING_TABLE_FIELD_ID = 'id';
    private const BUILDING_TABLE_FIELD_BUILDING_TYPE_ID = 'building_type_id';
    private const BUILDING_TABLE_FIELD_VILLAGE_ID = 'village_id';
    private const BUILDING_TABLE_FIELD_SLOT = 'slot';

    private const BUILDING_TYPE_TABLE_NAME = 'building_type';
    private const BUILDING_TYPE_TABLE_FIELD_ID = 'id';
    private const BUILDING_TYPE_TABLE_FIELD_BUILDING_TYPE_INFO_ID = 'building_type_info_id';
    private const BUILDING_TYPE_TABLE_FIELD_SLOT_TYPE = 'slot_type';
    private const BUILDING_TYPE_TABLE_FIELD_BUILD_TIME = 'build_time';
    private const BUILDING_TYPE_TABLE_FIELD_LEVEL = 'level';
    private const BUILDING_TYPE_TABLE_FIELD_NEXT_LEVEL_BUILDING_TYPE_ID = 'next_level_building_type_id';
    private const BUILDING_TYPE_TABLE_FIELD_PREV_LEVEL_BUILDING_TYPE_ID = 'prev_level_building_type_id';
    private const BUILDING_TYPE_TABLE_FIELD_FINISH_BUILD_ACTION = 'finish_build_action';
    private const BUILDING_TYPE_TABLE_FIELD_FINISH_DEMOLISH_ACTION = 'finish_demolish_action';

    private const BUILDING_TYPE_INFO_TABLE_NAME = 'building_type_info';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_ID = 'id';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_NAME = 'name';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_DESCRIPTION = 'description';

    private const BUILDING_COST_TABLE_NAME = 'building_cost';
    private const BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID = 'building_type_id';
    private const BUILDING_COST_TABLE_FIELD_RESOURCE_TYPE = 'resource_type';
    private const BUILDING_COST_TABLE_FIELD_VALUE = 'value';

    private const VILLAGE_RESOURCE_TABLE_NAME = 'village_resource';
    private const VILLAGE_RESOURCE_TABLE_FIELD_VILLAGE_ID = 'village_id';
    private const VILLAGE_RESOURCE_TABLE_FIELD_RESOURCE_TYPE = 'resource_type';
    private const VILLAGE_RESOURCE_TABLE_FIELD_VALUE = 'value';
    private const VILLAGE_RESOURCE_TABLE_FIELD_MAX_VALUE = 'max_value';
    private const VILLAGE_RESOURCE_TABLE_FIELD_GENERATION_PER_HOUR = 'generation_per_hour';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTables();

        $this->createTable(
            self::VILLAGE_TABLE_NAME,
            [
                self::VILLAGE_TABLE_FIELD_ID => $this->primaryKey(),
                self::VILLAGE_TABLE_FIELD_NAME => $this->string(255)->notNull(),
                self::VILLAGE_TABLE_FIELD_USER_ID => $this->integer()->notNull(),
            ] 
        );

        $this->createTable(
            self::BUILDING_TABLE_NAME,
            [
                self::BUILDING_TABLE_FIELD_ID => $this->primaryKey(),
                self::BUILDING_TABLE_FIELD_BUILDING_TYPE_ID => $this->smallInteger()->notNull(),
                self::BUILDING_TABLE_FIELD_VILLAGE_ID => $this->integer()->notNull(),
                self::BUILDING_TABLE_FIELD_SLOT => $this->smallInteger()->notNull(),
            ] 
        );

        $this->createTable(
            self::BUILDING_TYPE_TABLE_NAME,
            [
                self::BUILDING_TYPE_TABLE_FIELD_ID => 'smallserial', 
                self::BUILDING_TYPE_TABLE_FIELD_BUILDING_TYPE_INFO_ID => $this->smallInteger()->notNull(),
                self::BUILDING_TYPE_TABLE_FIELD_SLOT_TYPE => $this->smallInteger()->notNull(),
                self::BUILDING_TYPE_TABLE_FIELD_BUILD_TIME => $this->integer()->notNull()->defaultValue(1),
                self::BUILDING_TYPE_TABLE_FIELD_LEVEL => $this->smallInteger()->notNull()->defaultValue(0),
                self::BUILDING_TYPE_TABLE_FIELD_NEXT_LEVEL_BUILDING_TYPE_ID => $this->smallInteger(),
                self::BUILDING_TYPE_TABLE_FIELD_PREV_LEVEL_BUILDING_TYPE_ID => $this->smallInteger(),
                self::BUILDING_TYPE_TABLE_FIELD_FINISH_BUILD_ACTION => $this->text()->notNull(),
                self::BUILDING_TYPE_TABLE_FIELD_FINISH_DEMOLISH_ACTION => $this->text()->notNull(),
            ]
        );
        $this->addPrimaryKey(
            self::BUILDING_TYPE_TABLE_NAME . '_pk',
            self::BUILDING_TYPE_TABLE_NAME,
            self::BUILDING_TYPE_TABLE_FIELD_ID
        );

        $this->createTable(
            self::BUILDING_TYPE_INFO_TABLE_NAME,
            [
                self::BUILDING_TYPE_INFO_TABLE_FIELD_ID => 'smallserial',
                self::BUILDING_TYPE_INFO_TABLE_FIELD_NAME => $this->string(255)->notNull(),
                self::BUILDING_TYPE_INFO_TABLE_FIELD_DESCRIPTION => $this->text()->notNull(),
            ]
        );
        $this->addPrimaryKey(
            self::BUILDING_TYPE_INFO_TABLE_NAME . '_pk',
            self::BUILDING_TYPE_INFO_TABLE_NAME,
            self::BUILDING_TYPE_INFO_TABLE_FIELD_ID
        );

        $this->createTable(
            self::BUILDING_COST_TABLE_NAME,
            [
                self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID => $this->smallInteger()->notNull(),
                self::BUILDING_COST_TABLE_FIELD_RESOURCE_TYPE => $this->smallInteger()->notNull(),
                self::BUILDING_COST_TABLE_FIELD_VALUE => $this->integer()->notNull(),
            ]
        );

        $this->createTable(
            self::VILLAGE_RESOURCE_TABLE_NAME,
            [
                self::VILLAGE_RESOURCE_TABLE_FIELD_VILLAGE_ID => $this->integer()->notNull(),
                self::VILLAGE_RESOURCE_TABLE_FIELD_RESOURCE_TYPE => $this->smallInteger()->notNull(),
                self::VILLAGE_RESOURCE_TABLE_FIELD_VALUE => $this->integer()->notNull()->defaultValue(250),
                self::VILLAGE_RESOURCE_TABLE_FIELD_MAX_VALUE => $this->integer()->notNull()->defaultValue(500),
                self::VILLAGE_RESOURCE_TABLE_FIELD_GENERATION_PER_HOUR => $this->integer()->notNull()->defaultValue(5),
            ]
        );

        $this->addForeignKey(
            'village_user_id_fk',
            self::VILLAGE_TABLE_NAME, self::VILLAGE_TABLE_FIELD_USER_ID,
            self::USER_TABLE_NAME, self::USER_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            self::BUILDING_TABLE_NAME . '_'  . self::BUILDING_TABLE_FIELD_BUILDING_TYPE_ID . '_fk',
            self::BUILDING_TABLE_NAME, self::BUILDING_TABLE_FIELD_BUILDING_TYPE_ID,
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            self::BUILDING_TABLE_NAME . '_'  . self::BUILDING_TABLE_FIELD_VILLAGE_ID . '_fk',
            self::BUILDING_TABLE_NAME, self::BUILDING_TABLE_FIELD_VILLAGE_ID,
            self::VILLAGE_TABLE_NAME, self::VILLAGE_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            self::BUILDING_TYPE_TABLE_NAME . '_' . self::BUILDING_TYPE_TABLE_FIELD_BUILDING_TYPE_INFO_ID . '_fk',
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_BUILDING_TYPE_INFO_ID,
            self::BUILDING_TYPE_INFO_TABLE_NAME, self::BUILDING_TYPE_INFO_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            self::BUILDING_TYPE_TABLE_NAME . '_' . self::BUILDING_TYPE_TABLE_FIELD_NEXT_LEVEL_BUILDING_TYPE_ID . '_fk',
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_NEXT_LEVEL_BUILDING_TYPE_ID,
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_ID
        );

        $this->addForeignKey(
            self::BUILDING_TYPE_TABLE_NAME . '_' . self::BUILDING_TYPE_TABLE_FIELD_PREV_LEVEL_BUILDING_TYPE_ID . '_fk',
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_PREV_LEVEL_BUILDING_TYPE_ID,
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_ID
        );

        $this->addForeignKey(
            self::VILLAGE_RESOURCE_TABLE_NAME . '_' . self::VILLAGE_RESOURCE_TABLE_FIELD_VILLAGE_ID . '_fk',
            self::VILLAGE_RESOURCE_TABLE_NAME, self::VILLAGE_RESOURCE_TABLE_FIELD_VILLAGE_ID,
            self::VILLAGE_TABLE_NAME, self::VILLAGE_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            self::BUILDING_COST_TABLE_NAME . '_' . self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID . '_fk',
            self::BUILDING_COST_TABLE_NAME, self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID,
            self::BUILDING_TYPE_TABLE_NAME, self::BUILDING_TYPE_TABLE_FIELD_ID,
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            self::BUILDING_TABLE_NAME . '_' . self::BUILDING_TABLE_FIELD_VILLAGE_ID . '_idx',
            self::BUILDING_TABLE_NAME,
            self::BUILDING_TABLE_FIELD_VILLAGE_ID
        );

        $this->createIndex(
            self::BUILDING_COST_TABLE_NAME . '_' . self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID . '_idx',
            self::BUILDING_COST_TABLE_NAME,
            self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID
        );

        $this->createIndex(
            self::VILLAGE_TABLE_NAME . '_' . self::VILLAGE_TABLE_FIELD_USER_ID . '_idx',
            self::VILLAGE_TABLE_NAME,
            self::VILLAGE_TABLE_FIELD_USER_ID
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTables();
        return true;
    }

    private function dropTables()
    {
        $tables = [
            self::BUILDING_COST_TABLE_NAME,
            self::BUILDING_TABLE_NAME,
            self::BUILDING_TYPE_TABLE_NAME,
            self::BUILDING_TYPE_INFO_TABLE_NAME,
            self::VILLAGE_RESOURCE_TABLE_NAME,
            self::VILLAGE_TABLE_NAME,
        ];

        foreach ($tables as $table) {
            $this->execute("DROP TABLE IF EXISTS $table");
        }
    }
}
