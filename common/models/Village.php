<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "village".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 *
 * @property Building[] $buildings
 * @property User $user
 * @property VillageResource[] $villageResources
 */
class Village extends \yii\db\ActiveRecord
{

    public const TABLE_NAME = 'village';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_USER_ID = 'user_id';

    private array $resources;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'village';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Buildings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildings()
    {
        return $this
            ->hasMany(Building::class, ['village_id' => 'id'])
            ->cache(5);
    }

    public function getResourceBuildings()
    {
        return $this->getBuildings()
            ->where(
                [
                    Building::FIELD_SLOT_TYPE => [
                        Building::SLOT_TYPE_RESOURCES, 
                        Building::SLOT_TYPE_UTILITY
                    ]
                ]
            )->all();
    }

    public function getVillageBuildings()
    {
        return $this->getBuildings()
            ->where(
                [
                    Building::FIELD_SLOT_TYPE => [
                        Building::SLOT_TYPE_VILLAGE, 
                        Building::SLOT_TYPE_UTILITY
                    ]
                ]
            )->all();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[VillageResources]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVillageResources()
    {
        return $this
            ->hasMany(VillageResource::class, ['village_id' => 'id'])
            ->cache(5);
    }

    public function initResourceSet()
    {
        $villageResources = $this->getVillageResources()->all();
        foreach ($villageResources as $villageResource) {
            $this->resources[$villageResource->getResourceNameByType()] = [
                'value' => $villageResource->value,
                'maxValue' => $villageResource->max_value,
                'generationPerHour' => $villageResource->generation_per_hour
            ];
        }
    }

    /**
     * @return array
     */
    public function getResourceSet(): array
    {
        if (! isset($this->resources)) {
            $this->initResourceSet();
        }
        return $this->resources;
    }
}

