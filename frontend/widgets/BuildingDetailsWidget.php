<?php

namespace frontend\widgets;

use yii\base\Widget;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class BuildingDetailsWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $content = '<div class="building-details hidden">';
        $content .= '<h2>Building Name</h2>';
        $content .= '<p>Building Description</p>';
        $content .= '<div class="buttons">';
        $content .= $this->createUpgradeForm(0);
        // @TODO: Add option to demolish buildings
        // $content .= $this->createDemolishForm(0);
        $content .= '</div>';
        $content .= '<div class="exit-btn">X</div>';
        $content .= '</div>';
        return $content;
    }

    private function createUpgradeForm(int $buildingId): string
    {
        $formHtml = '<form action="' . Url::to('queue/upgrade-building') . '" method="POST">';
        $formHtml .= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken());
        $formHtml .= Html::hiddenInput('building_id', $buildingId);
        $formHtml .= Html::submitButton('Upgrade');
        $formHtml .= '</form>';
        return $formHtml;
    }

    private function createDemolishForm(int $buildingId): string
    {
        $formHtml = '<form action="' . Url::to('queue/demolish-building') . '" method="POST">';
        $formHtml .= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken());
        $formHtml .= Html::hiddenInput('building_id', $buildingId);
        $formHtml .= Html::submitButton('Demolish');
        $formHtml .= '</form>';
        return $formHtml;
    }
}
