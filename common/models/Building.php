<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property int $building_type_id
 * @property int $village_id
 * @property int $slot
 * @property int $slot_type
 * @property int $resource_type
 * @property int $level
 * @property int $bulding_type_info_id
 *
 * @property BuildingType $buildingType
 * @property Village $village
 */
class Building extends \yii\db\ActiveRecord
{

    public const FIELD_SLOT_TYPE = 'slot_type';
    public const FIELD_SLOT = 'slot';

    public const SLOT_TYPE_UTILITY = 0;
    public const SLOT_TYPE_VILLAGE = 1;
    public const SLOT_TYPE_RESOURCES = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['building_type_id', 'village_id', 'slot'], 'required'],
            [['building_type_id', 'village_id', 'slot'], 'default', 'value' => null],
            [['building_type_id', 'village_id', 'slot'], 'integer'],
            [['building_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingType::class, 'targetAttribute' => ['building_type_id' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::class, 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'building_type_id' => 'Building Type ID',
            'village_id' => 'Village ID',
            'slot' => 'Slot',
        ];
    }

    /**
     * Gets query for [[BuildingType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingType()
    {
        return $this
            ->hasOne(BuildingType::class, ['id' => 'building_type_id'])
            ->cache()
            ->one();
    }

    /**
     * Gets query for [[Village]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::class, ['id' => 'village_id']);
    }

    public function getBuildingTypeInfo()
    {
        return $this
            ->hasOne(BuildingTypeInfo::class, ['id' => 'building_type_info_id'])
            ->cache()
            ->one();
    }

    public function upgrade(): bool
    {
        $nextLevelBuildingTypeId = $this->getBuildingType()->next_level_building_type_id;
        if (! $nextLevelBuildingTypeId) {
            return false;
        }

        $nextLevelBuildingType = BuildingType::findOne($nextLevelBuildingTypeId);

        $this->building_type_id = $nextLevelBuildingType->id;
        $this->building_type_info_id = $nextLevelBuildingType->building_type_info_id;
        $this->level = $nextLevelBuildingType->level;

        return $this->save();
    }

    public static function create(int $buildingTypeId, int $resourceType, int $slotType, int $level, int $buildingTypeInfoId)
    {
        $building = new Building();
        $building->building_type_id = $buildingTypeId;
        $building->resource_type = $resourceType;
        $building->slot_type = $slotType;
        $building->level = $level;
        $building->building_type_info_id = $buildingTypeInfoId;
        return $building;
    }
}

