<?php

use yii\db\Migration;

/**
 * Class m231005_185251_add_basic_data
 */
class m231005_185251_add_basic_data extends Migration
{
    private const BUILDING_TABLE_NAME = 'building';

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
    private const BUILDING_TYPE_TABLE_FIELD_RESOURCE_TYPE = 'resource_type';

    private const BUILDING_TYPE_INFO_TABLE_NAME = 'building_type_info';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_ID = 'id';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_NAME = 'name';
    private const BUILDING_TYPE_INFO_TABLE_FIELD_DESCRIPTION = 'description';

    private const BUILDING_COST_TABLE_NAME = 'building_cost';
    private const BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID = 'building_type_id';
    private const BUILDING_COST_TABLE_FIELD_RESOURCE_TYPE = 'resource_type';
    private const BUILDING_COST_TABLE_FIELD_VALUE = 'value';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            self::BUILDING_TYPE_INFO_TABLE_NAME,
            [
                self::BUILDING_TYPE_INFO_TABLE_FIELD_ID,
                self::BUILDING_TYPE_INFO_TABLE_FIELD_NAME,
                self::BUILDING_TYPE_INFO_TABLE_FIELD_DESCRIPTION
            ],
            [
                [0, '', ''],
                [1, 'Woodcutter', 'Generates wood'],
                [2, 'Clay Pit', 'Generates clay'],
                [3, 'Iron Mine', 'Generates iron'],
                [4, 'Crop', 'Generates wheat']
            ]
        );

        $this->batchInsert(
            self::BUILDING_TYPE_TABLE_NAME,
            [
                self::BUILDING_TYPE_TABLE_FIELD_ID,
                self::BUILDING_TYPE_TABLE_FIELD_BUILDING_TYPE_INFO_ID ,
                self::BUILDING_TYPE_TABLE_FIELD_FINISH_DEMOLISH_ACTION,
                self::BUILDING_TYPE_TABLE_FIELD_FINISH_BUILD_ACTION,
                self::BUILDING_TYPE_TABLE_FIELD_PREV_LEVEL_BUILDING_TYPE_ID,
                self::BUILDING_TYPE_TABLE_FIELD_NEXT_LEVEL_BUILDING_TYPE_ID,
                self::BUILDING_TYPE_TABLE_FIELD_LEVEL,
                self::BUILDING_TYPE_TABLE_FIELD_BUILD_TIME,
                self::BUILDING_TYPE_TABLE_FIELD_SLOT_TYPE,
                self::BUILDING_TYPE_TABLE_FIELD_RESOURCE_TYPE
            ],
            [
                // Utility - empty building
                [0, 0, '', '', null, null, 0, 0, -1, 0],
                // Woodcutter
                [1, 1, 'building/demolish', 'building/upgrade', null, 2, 0, 0, 2, 1],
                [2, 1, 'building/demolish', 'building/upgrade', 1, 3, 1, 260, 2, 1],
                [3, 1, 'building/demolish', 'building/upgrade', 2, 4, 2, 620, 2, 1],
                [4, 1, 'building/demolish', 'building/upgrade', 3, 5, 3, 1190, 2, 1],
                [5, 1, 'building/demolish', 'building/upgrade', 4, 6, 4, 2100, 2, 1],
                [6, 1, 'building/demolish', 'building/upgrade', 5, 7, 5, 3560, 2, 1],
                [7, 1, 'building/demolish', 'building/upgrade', 6, 8, 6, 5890, 2, 1],
                [8, 1, 'building/demolish', 'building/upgrade', 7, 9, 7, 9620, 2, 1],
                [9, 1, 'building/demolish', 'building/upgrade', 8, 10, 8, 15590, 2, 1],
                [10, 1, 'building/demolish', 'building/upgrade', 9, 11, 9, 25150, 2, 1],
                [11, 1, 'building/demolish', 'building/upgrade', 10, null, 10, 40440, 2, 1],
                // Clay pit
                [12, 2, 'building/demolish', 'building/upgrade', null, 13, 0, 0, 2, 2],
                [13, 2, 'building/demolish', 'building/upgrade', 12, 14, 1, 220, 2, 2],
                [14, 2, 'building/demolish', 'building/upgrade', 13, 15, 2, 550, 2, 2],
                [15, 2, 'building/demolish', 'building/upgrade', 14, 16, 3, 1080, 2, 2],
                [16, 2, 'building/demolish', 'building/upgrade', 15, 17, 4, 1930, 2, 2],
                [17, 2, 'building/demolish', 'building/upgrade', 16, 18, 5, 3290, 2, 2],
                [18, 2, 'building/demolish', 'building/upgrade', 17, 19, 6, 5470, 2, 2],
                [19, 2, 'building/demolish', 'building/upgrade', 18, 20, 7, 8950, 2, 2],
                [20, 2, 'building/demolish', 'building/upgrade', 19, 21, 8, 14520, 2, 2],
                [21, 2, 'building/demolish', 'building/upgrade', 20, 22, 9, 23430, 2, 2],
                [22, 2, 'building/demolish', 'building/upgrade', 21, null, 10, 37690, 2, 2],
                // Iron mine
                [23, 3, 'building/demolish', 'building/upgrade', null, 24, 0, 0, 2, 3],
                [24, 3, 'building/demolish', 'building/upgrade', 23, 25, 1, 450, 2, 3],
                [25, 3, 'building/demolish', 'building/upgrade', 24, 26, 2, 920, 2, 3],
                [26, 3, 'building/demolish', 'building/upgrade', 25, 27, 3, 1670, 2, 3],
                [27, 3, 'building/demolish', 'building/upgrade', 26, 28, 4, 2880, 2, 3],
                [28, 3, 'building/demolish', 'building/upgrade', 27, 29, 5, 4800, 2, 3],
                [29, 3, 'building/demolish', 'building/upgrade', 28, 30, 6, 7880, 2, 3],
                [30, 3, 'building/demolish', 'building/upgrade', 29, 31, 7, 12810, 2, 3],
                [31, 3, 'building/demolish', 'building/upgrade', 30, 32, 8, 20690, 2, 3],
                [32, 3, 'building/demolish', 'building/upgrade', 31, 33, 9, 33310, 2, 3],
                [33, 3, 'building/demolish', 'building/upgrade', 32, null, 10, 53500, 2, 3],
                // Wheat crop
                [34, 4, 'building/demolish', 'building/upgrade', null, 35, 0, 0, 2, 4],
                [35, 4, 'building/demolish', 'building/upgrade', 34, 36, 1, 150, 2, 4],
                [36, 4, 'building/demolish', 'building/upgrade', 35, 37, 2, 440, 2, 4],
                [37, 4, 'building/demolish', 'building/upgrade', 36, 38, 3, 900, 2, 4],
                [38, 4, 'building/demolish', 'building/upgrade', 37, 39, 4, 1650, 2, 4],
                [39, 4, 'building/demolish', 'building/upgrade', 38, 40, 5, 2830, 2, 4],
                [40, 4, 'building/demolish', 'building/upgrade', 39, 41, 6, 4730, 2, 4],
                [41, 4, 'building/demolish', 'building/upgrade', 40, 42, 7, 7780, 2, 4],
                [42, 4, 'building/demolish', 'building/upgrade', 41, 43, 8, 12640, 2, 4],
                [43, 4, 'building/demolish', 'building/upgrade', 42, 44, 9, 20430, 2, 4],
                [44, 4, 'building/demolish', 'building/upgrade', 43, null, 10, 32880, 2, 4],
            ]
        );

        $this->batchInsert(
            self::BUILDING_COST_TABLE_NAME,
            [
                self::BUILDING_COST_TABLE_FIELD_BUILDING_TYPE_ID,
                self::BUILDING_COST_TABLE_FIELD_RESOURCE_TYPE,
                self::BUILDING_COST_TABLE_FIELD_VALUE
            ],
            [
                // [Wood], [Clay], [Iron], [Wheat]
                // Woodcutter
                [2, 1, 40], [2, 2, 100], [2, 3, 50], [2, 4, 60],
                [3, 1, 65], [3, 2, 165], [3, 3, 85], [3, 4, 100],
                [4, 1, 110], [4, 2, 280], [4, 3, 140], [4, 4, 165],
                [5, 1, 185], [5, 2, 465], [5, 3, 235], [5, 4, 280],
                [6, 1, 310], [6, 2, 780], [6, 3, 390], [6, 4, 465],
                [7, 1, 520], [7, 2, 1300], [7, 3, 650], [7, 4, 780],
                [8, 1, 870], [8, 2, 2170], [8, 3, 1085], [8, 4, 1300],
                [9, 1, 1450], [9, 2, 3625], [9, 3, 1910], [9, 4, 2175],
                [10, 1, 2420], [10, 2, 6050], [10, 3, 3025], [10, 4, 3630],
                [11, 1, 4040], [11, 2, 11115], [11, 3, 5050], [11, 4, 6060],
                // Clay pit
                [13, 1, 80], [13, 2, 40], [13, 3, 80], [13, 4, 50],
                [14, 1, 135], [14, 2, 65], [14, 3, 135], [14, 4, 85],
                [15, 1, 225], [15, 2, 110], [15, 3, 225], [15, 4, 140],
                [16, 1, 375], [16, 2, 185], [16, 3, 375], [16, 4, 235],
                [17, 1, 620], [17, 2, 310], [17, 3, 620], [17, 4, 390],
                [18, 1, 1040], [18, 2, 520], [18, 3, 1040], [18, 4, 650],
                [19, 1, 1735], [19, 2, 870], [19, 3, 1735], [19, 4, 1085],
                [20, 1, 2900], [20, 2, 1450], [20, 3, 2900], [20, 4, 1810],
                [21, 1, 4840], [21, 2, 2420], [21, 3, 4840], [21, 4, 3025],
                [22, 1, 8080], [22, 2, 4040], [22, 3, 8080], [22, 4, 5050],
                // Iron mine
                [24, 1, 100], [24, 2, 80], [24, 3, 30], [24, 4, 60],
                [25, 1, 165], [25, 2, 135], [25, 3, 50], [25, 4, 100],
                [26, 1, 280], [26, 2, 225], [26, 3, 85], [26, 4, 165],
                [27, 1, 465], [27, 2, 375], [27, 3, 140], [27, 4, 280],
                [28, 1, 780], [28, 2, 620], [28, 3, 235], [28, 4, 465],
                [29, 1, 1300], [29, 2, 1040], [29, 3, 390], [29, 4, 780],
                [30, 1, 2170], [30, 2, 1735], [30, 3, 650], [30, 4, 1300],
                [31, 1, 3625], [31, 2, 2900], [31, 3, 1085], [31, 4, 2175],
                [32, 1, 6050], [32, 2, 4840], [32, 3, 1815], [32, 4, 3630],
                [33, 1, 10105], [33, 2, 8080], [33, 3, 3030], [33, 4, 6060],
                // Wheat crop
                [35, 1, 70], [35, 2, 90], [35, 3, 70], [35, 4, 20],
                [36, 1, 115], [36, 2, 150], [36, 3, 115], [36, 4, 35],
                [37, 1, 195], [37, 2, 250], [37, 3, 195], [37, 4, 55],
                [38, 1, 325], [38, 2, 420], [38, 3, 325], [38, 4, 95],
                [39, 1, 545], [39, 2, 700], [39, 3, 545], [39, 4, 155],
                [40, 1, 910], [40, 2, 1170], [40, 3, 910], [40, 4, 260],
                [41, 1, 1520], [41, 2, 1950], [41, 3, 1520], [41, 4, 435],
                [42, 1, 2535], [42, 2, 3260], [42, 3, 2535], [42, 4, 725],
                [43, 1, 4235], [43, 2, 5445], [43, 3, 4235], [43, 4, 1210],
                [44, 1, 7070], [44, 2, 9095], [44, 3, 7070], [44, 4, 2020],
            ]
        );
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable(self::BUILDING_COST_TABLE_NAME);
        $this->db->createCommand("TRUNCATE TABLE " . self::BUILDING_TYPE_TABLE_NAME . " CASCADE")->execute();
        $this->db->createCommand("TRUNCATE TABLE " . self::BUILDING_TYPE_INFO_TABLE_NAME . " CASCADE")->execute();

        $this->db->createCommand("SELECT setval(pg_get_serial_sequence('" . self::BUILDING_TABLE_NAME . "', 'id'), coalesce(MAX(id), 1)) FROM " . self::BUILDING_TABLE_NAME)->execute();
        $this->db->createCommand("SELECT setval(pg_get_serial_sequence('" . self::BUILDING_TYPE_TABLE_NAME . "', 'id'), coalesce(MAX(id), 1)) FROM " . self::BUILDING_TYPE_TABLE_NAME)->execute();
        $this->db->createCommand("SELECT setval(pg_get_serial_sequence('" . self::BUILDING_TYPE_INFO_TABLE_NAME . "', 'id'), coalesce(MAX(id), 1)) FROM " . self::BUILDING_TYPE_INFO_TABLE_NAME)->execute();

        return true;
    }
}
