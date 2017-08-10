<?php

use yii\helpers\Html;

/* @var $this yii\web\View
 * @var $news \app\models\News[]
 */
?>

<h2>
    <?= Yii::t('app', 'Last News:') ?>
</h2>
<div class="news row">
    <?php foreach ($news as $newsItem): ?>
        <div class="news-item col-xs-12 col-sm-6 col-md-4">
            <h3>
                <?= Html::encode($newsItem->title) ?>
            </h3>
            <span class="date">
                <?= Yii::$app->formatter->asDate($newsItem->create_time, 'php:Y-m-d'); ?>
            </span>
            <div>
                <?= Html::img($newsItem->getThumbUploadUrl('image', 'news_thumb'), ['class' => 'news-image']); ?>
                <?= Html::encode($newsItem->short_text) ?>
                <br>
                <?= Html::a(Yii::t('app', 'Read more'),
                            ['news/view', 'slug' => $newsItem->slug]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>