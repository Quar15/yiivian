<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\bootstrap5\Html;

class ResourceStatusWidget extends Widget
{
    public array $resourceSet;

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $elements = '<div class="resources-status">';
        foreach ($this->resourceSet as $resourceName => $resource) {
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
