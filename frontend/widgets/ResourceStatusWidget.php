<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\bootstrap5\Html;
use common\models\Village;
use common\models\VillageResourceSet;

class ResourceStatusWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $village = Village::find()
            ->where([Village::FIELD_USER_ID => \Yii::$app->getUser()->getId()])
            ->one();

        $resourceSet = new VillageResourceSet($village);
        $resources = $resourceSet->getResourceSet();

        $elements = '<div class="resources-status">';
        foreach ($resources as $resourceName => $resource) {
            $elements .= '<div class="resource-status-element">';
            $elements .= Html::img("@web/img/" . $resourceName . "_small.png");
            $elements .= '<p>' . $resource['value'] . '/' . $resource['maxValue'] . '</p>';
            $elements .= '</div>';
        } 

        // Wheat usage
        $elements .= '<div class="resource-status-element">';
        $elements .= Html::img("@web/img/wheat_small.png");
        $elements .= '<p>0/0</p>';
        $elements .= '</div>';

        $elements .= '</div>';

        return $elements;
    }
}
