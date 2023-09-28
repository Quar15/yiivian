<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\bootstrap5\Html;

class ResourceProductionStatusWidget extends Widget
{
    public const RESOURCE_SET = 'resourceSet';
    public array $resourceSet;

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $elements = '<div class="resource-generation-summary">';
        $elements .= '<h3>Production</h3>';
        foreach ($this->resourceSet as $resourceName => $resource) {
            $elements .= '<div>';
            $elements .= Html::img("@web/img/" . $resourceName . "_small.png");
            $elements .= '<p>' . $resourceName . '</p>';
            $elements .= '<p class="bold">' . $resource['generationPerHour'] . '</p>';
            $elements .= '<p>per hour</p>';
            $elements .= '</div>';
        } 

        $elements .= '</div>';

        return $elements;
    }
}

