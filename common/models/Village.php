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
            )->orderBy(Building::FIELD_SLOT)
            ->all();
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
            )->orderBy(Building::FIELD_SLOT)
            ->all();
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

    public function create(int $userId, string $villageName, array $buildings, array $villageResources): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->name = $villageName;
            $this->user_id = $userId;
            $this->save();

            foreach($buildings as $building) {
                $building->village_id = $this->id;
                $building->save();
            }

            foreach($villageResources as $villageResource) {
                $villageResource->village_id =$this->id;
                $villageResource->save();    
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }

        return true;
    }

    public function createDefault($userId)
    {
        $user = User::findOne($userId);
        if (! $user) { return false; }
        $username = $user->username;
        $defaultVillageName = "$username's Village";
        
        $buildings = [];

        $woodcutter = Building::create(1, 1, 2, 0, 1);
        $woodcutterSlots = [1, 3, 15, 18];
        foreach($woodcutterSlots as $slot) {
            $woodcutter->slot = $slot;
            $buildings[] = clone $woodcutter;    
        }

        $clayPit = Building::create(12, 2, 2, 0, 2);
        $clayPitSlots = [5, 6, 17, 19];
        foreach($clayPitSlots as $slot) {
            $clayPit->slot = $slot;
            $buildings[] = clone $clayPit;    
        }

        $ironMine = Building::create(23, 3, 2, 0, 3);
        $ironMineSlots = [4, 7, 11, 12];
        foreach($ironMineSlots as $slot) {
            $ironMine->slot = $slot;
            $buildings[] = clone $ironMine;    
        }

        $crop = Building::create(34, 4, 2, 0, 4);
        $cropSlots = [2, 8, 9, 13, 14, 16];
        foreach($cropSlots as $slot) {
            $crop->slot = $slot;
            $buildings[] = clone $crop;    
        }

        $emptyBuilding = Building::create(0, 0, 1, 0, 0);
        $emptyBuildingsSlots = [
            1, 2, 3, 
            4, 5, 6, 7, 
            8, 9, 11, 12, 
            13, 14, 15, 16, 
            17, 18, 19
        ];
        foreach($emptyBuildingsSlots as $slot) {
            $emptyBuilding->slot = $slot;
            $buildings[] = clone $emptyBuilding;
        }

        $middleBuilding = Building::create(0, -1, 1, 0, 0);
        $middleBuilding->slot = 10;
        $buildings[] = clone $middleBuilding;
        $middleBuilding->slot_type = 2;
        $buildings[] = clone $middleBuilding;

        $woodResource = VillageResource::create(1, 100, 500, 5);
        $clayResource = VillageResource::create(2, 100, 500, 5);
        $ironResource = VillageResource::create(3, 100, 500, 5);
        $wheatResource = VillageResource::create(4, 100, 500, 5);
        $villageResources = [$woodResource, $clayResource, $ironResource, $wheatResource];

        return $this->create($userId, $defaultVillageName, $buildings, $villageResources);
    }
}

