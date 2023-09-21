<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Village';
?>

<div class="main-panel">
    <div class="buildings-layout">
            <div>
                <a href="#1"><div class="hexagon hexagon-wood"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p>00</p></div></a>
            </div>
            <div>
                <a href="#2"><div class="hexagon hexagon-iron"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p>00</p></div></a>
            </div>
            <div>
                <a href="#3"><div class="hexagon hexagon-food"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-village"><p>Village</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-iron"><p>00</p></div></a>
            </div>
            <div>
                <a href="#3"><div class="hexagon hexagon-food"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-food"><p>00</p></div></a>
            </div>
            <div>
                <a href="#5"><div class="hexagon hexagon-clay"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-wood"><p>00</p></div></a><a href="#"><div class="hexagon hexagon-clay"><p>00</p></div></a>
            </div>
        </div>
        <div>
            <div class="resource-generation-summary">
                <h3>Production</h3>
                <div><?= Html::img("@web/img/lumber_small.png")?><p>Wood:</p><p class="bold">2</p><p>per hour</p></div>
                <div><?= Html::img("@web/img/clay_small.png")?><p>Clay:</p><p class="bold">2</p><p>per hour</p></div>
                <div><?= Html::img("@web/img/iron_small.png")?><p>Iron:</p><p class="bold">2</p><p>per hour</p></div>
                <div><?= Html::img("@web/img/wheat_small.png")?><p>Wheat:</p><p class="bold">9999</p><p>per hour</p></div>
            </div>
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
</div>
