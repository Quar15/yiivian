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
        $village = new Village();
        return $village->create($userId, $villageName, $buildings, $villageResources);
    }
    
    public function actionCreateDefaultVillage(int $userId): bool
    {
        $village = new Village();
        return $village->createDefault($userId);
    }

}
