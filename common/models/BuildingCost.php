<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "building_cost".
 *
 * @property int $building_type_id
 * @property int $resource_type
 * @property int $value
 *
 * @property BuildingType $buildingType
 */
class BuildingCost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building_cost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['building_type_id', 'resource_type', 'value'], 'required'],
            [['building_type_id', 'resource_type', 'value'], 'default', 'value' => null],
            [['building_type_id', 'resource_type', 'value'], 'integer'],
            [['building_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingType::class, 'targetAttribute' => ['building_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'building_type_id' => 'Building Type ID',
            'resource_type' => 'Resource Type',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[BuildingType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingType()
    {
        return $this->hasOne(BuildingType::class, ['id' => 'building_type_id']);
    }
}

