<?php

use common\models\VillageResource;
use frontend\widgets\ResourceProductionStatusWidget;
use frontend\widgets\ResourceLayoutWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$villages = \Yii::$app->user->identity->villages;
$currVillage = $villages[array_key_first($villages)];
$this->title = 'Resources';
?>

<div class="main-panel">
    <?= ResourceLayoutWidget::widget([ResourceLayoutWidget::VILLAGE_RESOURCE_BUILDINGS_LIST => $currVillage->getResourceBuildings()]); ?>
    <div>
        <?= ResourceProductionStatusWidget::widget([ResourceProductionStatusWidget::RESOURCE_SET => $currVillage->getResourceSet()]);  ?>
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
