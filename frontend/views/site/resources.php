<?php

use frontend\widgets\ResourceProductionStatusWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Resources';
?>

<div class="main-panel">
    <div class="buildings-layout">
        <div>
            <a href="#1"><div class="hexagon hexagon-wood"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p class="building-level">00</p></div></a>
        </div>
        <div>
            <a href="#2"><div class="hexagon hexagon-iron"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p class="building-level">00</p></div></a>
        </div>
        <div>
<a href="#3"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a><a href="<?= Url::to(['site/village']) ?>"><div class="hexagon hexagon-village"><p>Village</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p class="building-level">00</p></div></a>
        </div>
        <div>
            <a href="#3"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p class="building-level">00</p></div></a>
        </div>
        <div>
            <a href="#5"><div class="hexagon hexagon-clay"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p class="building-level">00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p class="building-level">00</p></div></a>
        </div>
    </div>
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
