<?php

namespace frontend\widgets;

use common\models\VillageResource;
use yii\base\Widget;
use yii\helpers\Url;

class VillageLayoutWidget extends Widget
{
    public const NUMBER_OF_SLOTS = 19;

    public const VILLAGE_BUILDINGS_LIST = 'villageBuildingsList';
    public array $villageBuildingsList;

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $elements = '<div class="buildings-layout">';
        $slotsInRow = 3;
        $slotsInRowTendency = 1;
        for ($i = 0; $i < self::NUMBER_OF_SLOTS;) {
            $elements .= '<div>';
            for ($j = 0; $j < $slotsInRow; $j++) {
                $elements .= $this->createSlot(
                    $i, 
                    $this->villageBuildingsList[$i]->getBuildingTypeInfo()->name,
                    $this->villageBuildingsList[$i]['resource_type'], 
                    $this->villageBuildingsList[$i]['level']
                );
                if ($this->villageBuildingsList[$i]['resource_type'] == -1) { $slotsInRowTendency = -1; }
                $i++;
            }
            $elements .= '</div>';
            $slotsInRow += $slotsInRowTendency;
        }

        $elements .= '</div>';
        return $elements;
    }

    private function createSlot(int $slot, string $buildingName, int $resourceType = -1, int $level = 0): string
    {
        $link = "#?slot=$slot";
        $className = '';
        $lvlText = "$level";
        switch ($resourceType) {
            case VillageResource::RESOURCE_WOOD_TYPE_VALUE:
                $className = "hexagon-" . VillageResource::RESOURCE_WOOD;
                break;
            case VillageResource::RESOURCE_CLAY_TYPE_VALUE:
                $className = "hexagon-" . VillageResource::RESOURCE_CLAY;
                break;
            case VillageResource::RESOURCE_IRON_TYPE_VALUE:
                $className = "hexagon-" . VillageResource::RESOURCE_IRON;
                break;
            case VillageResource::RESOURCE_WHEAT_TYPE_VALUE:
                $className = "hexagon-" . VillageResource::RESOURCE_WHEAT;
                break;
            case 0:
                if ($level == 0) {
                    $className = 'hexagon-empty';
                } else {
                    $className = "hexagon-building"; 
                }
                break;
            default:
                $link = Url::to(['site/village']);
                $className = "hexagon-village";
                $lvlText = "Village";
                break;
        }
        $slot = "<a href='$link'>";
        $slot .= "<div class='hexagon $className'>";
        $slot .= "<p>$buildingName</p>";
        $slot .= "<p class='building-level'>$lvlText</p>";
        $slot .= '</div></a>';
        return $slot;
    }
}
