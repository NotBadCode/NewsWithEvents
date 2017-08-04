<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class SlugAsset
 * @package app\assets
 */
class SlugAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/slug';

    public $js = [
        'js/slug-widget.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}