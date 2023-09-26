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
 *
 * @property BuildingType $buildingType
 * @property Village $village
 */
class Building extends \yii\db\ActiveRecord
{
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
        return $this->hasOne(BuildingType::class, ['id' => 'building_type_id']);
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
}

