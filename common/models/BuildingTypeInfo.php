<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "building_type_info".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property BuildingType[] $buildingTypes
 */
class BuildingTypeInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building_type_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[BuildingTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes()
    {
        return $this->hasMany(BuildingType::class, ['building_type_info_id' => 'id']);
    }
}

