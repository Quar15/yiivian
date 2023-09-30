<?php

use frontend\widgets\VillageLayoutWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$villages = \Yii::$app->user->identity->villages;
$currVillage = $villages[array_key_first($villages)];
$this->title = 'Village';
?>

<div class="main-panel">
    <?= VillageLayoutWidget::widget([VillageLayoutWidget::VILLAGE_BUILDINGS_LIST => $currVillage->getVillageBuildings()]) ?>
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
