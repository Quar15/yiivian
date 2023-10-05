<?php

namespace console\controllers;

use common\models\Building;
use yii\console\Controller;
use yii\helpers\Console;

class BuildingController extends Controller
{
    public function actionUpgradeBuilding(int $buildingId)
    {
        $building = Building::findOne($buildingId);
        if(! $building) {
            Console::stdout("@ERROR: Building with id '$buildingId' not found" . PHP_EOL);
            return 1;
        }
        
        if($building->upgrade()) {
            Console::stdout("@SUCCESS: Building($buildingId) upgraded" . PHP_EOL);
        } else {
            Console::stdout("@ERROR: Building($buildingId) upgrade failed" . PHP_EOL); 
            return 1;
        }
    }
}
