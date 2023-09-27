<?php

namespace common\models;

use common\models\Village;
use common\models\VillageResource;


class VillageResourceSet 
{
    private array $resources;

    public function __construct(Village $village)
    {
        $villageResources = $village->getVillageResources()->all();
        $this->initResourceValues($villageResources);
    }

    /**
     * @param VillageResource[]
     */
    private function initResourceValues(array $villageResources)
    {
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
        return $this->resources;
    }
}
