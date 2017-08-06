<?php

use yii\helpers\Html;

/**
 * @var \app\models\News $news
 */
?>
<p>
    <?= Yii::t('app', 'New News:') ?> <?= Html::encode($news->title) ?>
</p>
