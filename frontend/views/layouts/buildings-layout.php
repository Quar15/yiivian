<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\BuildingsAsset;
use frontend\widgets\FlashMessagesWidget;
use frontend\widgets\ResourceStatusWidget;
use yii\bootstrap5\Html;
use yii\helpers\Url;

BuildingsAsset::register($this);

$resourceSets = \Yii::$app->user->identity->resourceSets;
$currVillageResourceSet = $resourceSets[array_key_first($resourceSets)];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title>
    <?php 
        if (! empty($this->title)) {
            echo Html::encode(Yii::$app->name) . ' - ' .  Html::encode($this->title); 
        } else {
            echo Html::encode(Yii::$app->name);
        }
    ?>
    </title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken(), ['id' => "csrf"]) ?> 
    <nav>
        <div class="buttons">
            <a class="nav-main-btn" href="<?= Url::to(['site/resources']) ?>"><div class="main-btn-border"><?= Html::img("@web/img/icon-placeholder.png") ?></div><h2>Resources</h2></a>
            <a class="nav-main-btn" href="<?= Url::to(['site/village']) ?>"><div class="main-btn-border"><?= Html::img("@web/img/icon-placeholder.png") ?></div><h2>Village</h2></a>
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><?= Html::img("@web/img/icon-placeholder.png") ?></div><h2>Army</h2></a>
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><?= Html::img("@web/img/icon-placeholder.png") ?></div><h2>Messages</h2></a>
        </div>
        <?= ResourceStatusWidget::widget(['resourceSet' => $currVillageResourceSet]) ?>
    </nav>
    <?= FlashMessagesWidget::widget() ?>
    
    <div class="wrapper">
        <?= $content ?> 
    </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
