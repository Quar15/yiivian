<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "village_resource".
 *
 * @property int $village_id
 * @property int $resource_type
 * @property int $value
 * @property int $max_value
 * @property int $generation_per_hour
 *
 * @property Village $village
 */
class VillageResource extends \yii\db\ActiveRecord
{

    public const FIELD_VILLAGE_ID = 'village_id';
    public const FIELD_RESOURCE_TYPE = 'resource_type';
    public const FIELD_VALUE = 'value';
    public const FIELD_MAX_VALUE = 'max_value';
    public const FIELD_GENERATION_PER_HOUR = 'generation_per_hour';

    public const RESOURCE_WOOD = 'wood';
    public const RESOURCE_CLAY = 'clay';
    public const RESOURCE_IRON = 'iron';
    public const RESOURCE_WHEAT = 'wheat';


    public const RESOURCE_WOOD_TYPE_VALUE = 1;
    public const RESOURCE_CLAY_TYPE_VALUE = 2;
    public const RESOURCE_IRON_TYPE_VALUE = 3;
    public const RESOURCE_WHEAT_TYPE_VALUE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'village_resource';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['village_id', 'resource_type'], 'required'],
            [['village_id', 'resource_type', 'value', 'max_value', 'generation_per_hour'], 'default', 'value' => null],
            [['village_id', 'resource_type', 'value', 'max_value', 'generation_per_hour'], 'integer'],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::class, 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'village_id' => 'Village ID',
            'resource_type' => 'Resource Type',
            'value' => 'Value',
            'max_value' => 'Max Value',
            'generation_per_hour' => 'Generation Per Hour',
        ];
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

    public function getResourceNameByType(): string
    {
        $resourceNames = [
            self::RESOURCE_WOOD_TYPE_VALUE => self::RESOURCE_WOOD, 
            self::RESOURCE_CLAY_TYPE_VALUE => self::RESOURCE_CLAY, 
            self::RESOURCE_IRON_TYPE_VALUE => self::RESOURCE_IRON, 
            self::RESOURCE_WHEAT_TYPE_VALUE => self::RESOURCE_WHEAT, 
        ];

        return $resourceNames[$this->resource_type];
    }

    public static function create(int $resourceType, int $value, int $maxValue, int $generationPerHour): VillageResource 
    {
        $resource = new VillageResource();
        $resource->resource_type = $resourceType;
        $resource->value = $value;
        $resource->max_value = $maxValue;
        $resource->generation_per_hour = $generationPerHour;
        return $resource;
    }
}

