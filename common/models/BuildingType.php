<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "building_type".
 *
 * @property int $id
 * @property int $building_type_info_id
 * @property int $slot_type
 * @property int $build_time
 * @property int $level
 * @property int|null $next_level_building_type_id
 * @property int|null $prev_level_building_type_id
 * @property string $finish_build_action
 * @property string $finish_demolish_action
 *
 * @property BuildingCost[] $buildingCosts
 * @property BuildingTypeInfo $buildingTypeInfo
 * @property BuildingType[] $buildingTypes
 * @property BuildingType[] $buildingTypes0
 * @property Building[] $buildings
 * @property BuildingType $nextLevelBuildingType
 * @property BuildingType $prevLevelBuildingType
 */
class BuildingType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['building_type_info_id', 'slot_type', 'finish_build_action', 'finish_demolish_action'], 'required'],
            [['building_type_info_id', 'slot_type', 'build_time', 'level', 'next_level_building_type_id', 'prev_level_building_type_id'], 'default', 'value' => null],
            [['building_type_info_id', 'slot_type', 'build_time', 'level', 'next_level_building_type_id', 'prev_level_building_type_id'], 'integer'],
            [['finish_build_action', 'finish_demolish_action'], 'string'],
            [['next_level_building_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingType::class, 'targetAttribute' => ['next_level_building_type_id' => 'id']],
            [['prev_level_building_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingType::class, 'targetAttribute' => ['prev_level_building_type_id' => 'id']],
            [['building_type_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingTypeInfo::class, 'targetAttribute' => ['building_type_info_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'building_type_info_id' => 'Building Type Info ID',
            'slot_type' => 'Slot Type',
            'build_time' => 'Build Time',
            'level' => 'Level',
            'next_level_building_type_id' => 'Next Level Building Type ID',
            'prev_level_building_type_id' => 'Prev Level Building Type ID',
            'finish_build_action' => 'Finish Build Action',
            'finish_demolish_action' => 'Finish Demolish Action',
        ];
    }

    /**
     * Gets query for [[BuildingCosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingCosts()
    {
        return $this->hasMany(BuildingCost::class, ['building_type_id' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypeInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypeInfo()
    {
        return $this->hasOne(BuildingTypeInfo::class, ['id' => 'building_type_info_id']);
    }

    /**
     * Gets query for [[Buildings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildings()
    {
        return $this->hasMany(Building::class, ['building_type_id' => 'id']);
    }

    /**
     * Gets query for [[NextLevelBuildingType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNextLevelBuildingType()
    {
        return $this->hasOne(BuildingType::class, ['id' => 'next_level_building_type_id']);
    }

    /**
     * Gets query for [[PrevLevelBuildingType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrevLevelBuildingType()
    {
        return $this->hasOne(BuildingType::class, ['id' => 'prev_level_building_type_id']);
    }
}

