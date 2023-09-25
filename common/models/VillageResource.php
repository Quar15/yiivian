<?php

namespace app\models;

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
}

