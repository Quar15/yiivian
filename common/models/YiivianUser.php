<?php

namespace common\models;

use yii\web\IdentityInterface;
use common\models\User;
use common\models\Village;

class YiivianUser extends User implements IdentityInterface
{
    private $resourceSets;

    public function init()
    {
        parent::init();
    }

    public function initResourceSets()
    {
        $villages = Village::find()
            ->where([ Village::FIELD_USER_ID => \Yii::$app->user->id ])
            ->all();
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
