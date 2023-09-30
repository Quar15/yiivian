<?php

namespace common\models;

use yii\web\IdentityInterface;
use common\models\User;
use common\models\Village;

class YiivianUser extends User implements IdentityInterface
{
    private $resourceSets;
    private $villages;

    public function init()
    {
        parent::init();
    }

    public function initVillages()
    {
        $villages = Village::find()
            ->cache(5)
            ->where([Village::FIELD_USER_ID => \Yii::$app->user->id])
            ->all();
        foreach ($villages as $village) {
            $this->villages[$village->id] = $village;
        }
    }

    public function getVillages()
    {
        if (! isset($this->villages)) {
           $this->initVillages(); 
        }
        return $this->villages;
    }

    public function initResourceSets()
    {
        $villages = $this->getVillages();
        foreach ($villages as $village) {
            $this->resourceSets[$village->id] = $village->getResourceSet();
        }
    }

    public function getResourceSets()
    {
        if (! isset($this->resourceSets)) {
           $this->initResourceSets(); 
        }
        return $this->resourceSets;
    }
}
