<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('HOST_SERVER') or define('HOST_SERVER', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(YII_APP_BASE_PATH . '/common/components/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new common\yii\Application($config);
throw new \yii\web\HttpException(404, 'Site not found.');
