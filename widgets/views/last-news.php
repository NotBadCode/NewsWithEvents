<?php

use yii\helpers\Html;

/* @var $this yii\web\View
 * @var $news \app\models\News[]
 */
?>

<h2>
    <?= Yii::t('app', 'Last News:') ?>
</h2>
<div class="news">
    <?php foreach ($news as $newsItem): ?>
        <div class="news-item">
            <h3>
                <?= $newsItem->title ?>
            </h3>
            <div>
                <?= Html::img($newsItem->getThumbUploadUrl('image', 'news_thumb'), ['class' => 'news-image']); ?>
                <?= $newsItem->short_text ?>
                <br>
                <?= Html::a(Yii::t('app', 'Read more'),
                            ['news/view', 'slug' => $newsItem->slug]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
