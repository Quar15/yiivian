<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Buildings related frontend application asset bundle.
 */
class BuildingsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/building-style.css'
    ];
    public $js = [
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
