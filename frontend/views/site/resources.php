<?php

use frontend\widgets\ResourceProductionStatusWidget;
use frontend\widgets\ResourceLayoutWidget;
use frontend\widgets\BuildQueueWidget;
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
<form action="<?= Url::to('queue/upgrade-building') ?>" method="POST">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>
    <input type="number" name="building_id"/>
</form>
<form action="<?= Url::to('queue/cancel-upgrade-building') ?>" method="POST">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>
    <input type="number" name="queue_entry_id"/>
</form>
<?= BuildQueueWidget::widget([BuildQueueWidget::VILLAGE_QUEUE_BUILDINGS_LIST => $villageQueueBuildingsList]);  ?>
