<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
    <nav>
        <div class="buttons">
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><img src="./img/icon-placeholder.png"/></div><h2>Resources</h2></a>
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><img src="./img/icon-placeholder.png"/></div><h2>Village</h2></a>
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><img src="./img/icon-placeholder.png"/></div><h2>Army</h2></a>
            <a class="nav-main-btn" href="#"><div class="main-btn-border"><img src="./img/icon-placeholder.png"/></div><h2>Messages</h2></a>
        </div>
        <div class="resources-status">
            <div class="resource-status-element">
                <?= Html::img("@web/img/lumber_small.png")?>
                <p>999/999</p>
            </div>
            <div class="resource-status-element">
                <?= Html::img("@web/img/clay_small.png")?>
                <p>999/999</p>
            </div>
            <div class="resource-status-element">
                <?= Html::img("@web/img/iron_small.png")?>
                <p>999/999</p>
            </div>
            <div class="resource-status-element">
                <?= Html::img("@web/img/wheat_small.png")?>
                <p>999/999</p>
            </div>
            <div class="resource-status-element">
                <?= Html::img("@web/img/wheat_small.png")?>
                <p>0/0</p>
            </div>
        </div>
    </nav>

    <?php
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }
    ?>

    <div class="wrapper">
        <?= $content ?> 
    </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
