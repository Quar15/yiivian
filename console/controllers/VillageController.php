<?php

namespace console\controllers;

use common\models\Building;
use common\models\User;
use common\models\Village;
use common\models\VillageResource;
use Yii\base\Controller;

class VillageController extends Controller
{
    public function actionCreateAndSaveVillage(int $userId, string $villageName, array $buildings, array $villageResources)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $village = new Village();
            $village->name = $villageName;
            $village->user_id = $userId;
            $village->save();

            foreach($buildings as $building) {
                $building->village_id = $village->id;
                $building->save();
            }

            foreach($villageResources as $villageResource) {
                $villageResource->village_id =$village->id;
                $villageResource->save();    
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }


        return true;
    }
    
    public function actionCreateBasicVillage(int $userId): bool
    {
        $user = User::findOne($userId);
        if (! $user) { return false; }
        $username = $user->username;
        $defaultVillageName = "$username's Village";
        
        $buildings = [];
        
        $woodcutter = $this->createBuilding(1, 1, 2, 0, 1);
        $woodcutterSlots = [1, 3, 15, 18];
        foreach($woodcutterSlots as $slot) {
            $woodcutter->slot = $slot;
            $buildings[] = clone $woodcutter;    
        }

        $clayPit = $this->createBuilding(4, 2, 2, 0, 2);
        $clayPitSlots = [5, 6, 17, 19];
        foreach($clayPitSlots as $slot) {
            $clayPit->slot = $slot;
            $buildings[] = clone $clayPit;    
        }

        $ironMine = $this->createBuilding(7, 3, 2, 0, 3);
        $ironMineSlots = [4, 7, 11, 12];
        foreach($ironMineSlots as $slot) {
            $ironMine->slot = $slot;
            $buildings[] = clone $ironMine;    
        }

        $crop = $this->createBuilding(10, 4, 2, 0, 4);
        $cropSlots = [2, 8, 9, 13, 14, 16];
        foreach($cropSlots as $slot) {
            $crop->slot = $slot;
            $buildings[] = clone $crop;    
        }

        $emptyBuilding = $this->createBuilding(0, 0, 1, 0, 0);
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

        $middleBuilding = $this->createBuilding(0, -1, 1, 0, 0);
        $middleBuilding->slot = 10;
        $buildings[] = clone $middleBuilding;
        $middleBuilding->slot_type = 2;
        $buildings[] = clone $middleBuilding;

        $woodResource = $this->createResource(1, 100, 500, 5);
        $clayResource = $this->createResource(2, 100, 500, 5);
        $ironResource = $this->createResource(3, 100, 500, 5);
        $wheatResource = $this->createResource(4, 100, 500, 5);
        $villageResources = [$woodResource, $clayResource, $ironResource, $wheatResource];

        return $this->actionCreateAndSaveVillage($userId, $defaultVillageName, $buildings, $villageResources);
    }

    private function createBuilding(int $buildingTypeId, int $resourceType, int $slotType, int $level, int $buildingTypeInfoId): Building
    {
        $building = new Building();
        $building->building_type_id = $buildingTypeId;
        $building->resource_type = $resourceType;
        $building->slot_type = $slotType;
        $building->level = $level;
        $building->building_type_info_id = $buildingTypeInfoId;
        return $building;
    }

    private function createResource(int $resourceType, int $value, int $maxValue, int $generationPerHour): VillageResource 
    {
        $resource = new VillageResource();
        $resource->resource_type = $resourceType;
        $resource->value = $value;
        $resource->max_value = $maxValue;
        $resource->generation_per_hour = $generationPerHour;
        return $resource;
    }
}
