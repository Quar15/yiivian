<?php

use common\models\VillageResource;
use frontend\widgets\ResourceProductionStatusWidget;
use frontend\widgets\ResourceLayoutWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Resources';

$testingResourceBuildingsList = [
    [
        'slot' => 1,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WOOD_TYPE_VALUE,
    ],
    [
        'slot' => 2,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 3,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WOOD_TYPE_VALUE,
    ],
    [
        'slot' => 4,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_IRON_TYPE_VALUE,
    ],
    [
        'slot' => 5,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_CLAY_TYPE_VALUE,
    ],
    [
        'slot' => 6,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_CLAY_TYPE_VALUE,
    ],
    [
        'slot' => 7,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_IRON_TYPE_VALUE,
    ],
    [
        'slot' => 8,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 9,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 10,
        'level' => 0,
        'resource_type' => -1,
    ],
    [
        'slot' => 11,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_IRON_TYPE_VALUE,
    ],
    [
        'slot' => 12,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_IRON_TYPE_VALUE,
    ],
    [
        'slot' => 13,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 14,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 15,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WOOD_TYPE_VALUE,
    ],
    [
        'slot' => 16,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WHEAT_TYPE_VALUE,
    ],
    [
        'slot' => 17,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_CLAY_TYPE_VALUE,
    ],
    [
        'slot' => 18,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_WOOD_TYPE_VALUE,
    ],
    [
        'slot' => 19,
        'level' => 0,
        'resource_type' => VillageResource::RESOURCE_CLAY_TYPE_VALUE,
    ],
];
?>

<div class="main-panel">
    <?= ResourceLayoutWidget::widget([ResourceLayoutWidget::VILLAGE_RESOURCE_BUILDINGS_LIST => $testingResourceBuildingsList]); ?>
    <div>
        <?= ResourceProductionStatusWidget::widget([ResourceProductionStatusWidget::RESOURCE_SET => $resources]);  ?>
        <div class="units-summary">
            <h3>Troops</h3>
            <p>None</p>
        </div>
    </div>
</div>
<div class="build-queue">
    <h3>Building:</h3>
    <div class="build-queue-list">
        <div class="build-queue-element">
            <a href="#">X</a>
            <p>Building Name (Level XX)</p>
            <p>00:00:00</p>
            <p>Done at 00:00</p>
        </div>
        <div class="build-queue-element">
            <a href="#">X</a>
            <p>Very very long building name that will not fit (Level XX)</p>
            <p>00:00:00</p>
            <p>Done at 00:00</p>
        </div>
        <div class="build-queue-element">
            <a href="#">X</a>
            <p>Building Name (Level XX)</p>
            <p>00:00:00</p>
            <p>Done at 00:00</p>
        </div>
        <div class="build-queue-element">
            <a href="#">X</a>
            <p>Building Name (Level XX)</p>
            <p>00:00:00</p>
            <p>Done at 00:00</p>
        </div>
        <div class="build-queue-element">
            <a href="#">X</a>
            <p>Building Name (Level XX)</p>
            <p>00:00:00</p>
            <p>Done at 00:00</p>
        </div>
    </div>
</div>
