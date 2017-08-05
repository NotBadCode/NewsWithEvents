<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'title',
                                 [
                                     'format'    => 'html',
                                     'attribute' => 'image',
                                     'value'     => function ($model) {
                                         return Html::img($model->getThumbUploadUrl('image', 'news_thumb'));
                                     }
                                 ],
                                 'short_text',
                                 'create_time',
                                 [
                                     'format' => 'html',
                                     'value'  => function ($model) {
                                         if (Yii::$app->user->isGuest) {
                                             return Html::a(Yii::t('app', 'Preview'),
                                                            ['news/preview', 'slug' => $model->slug]);
                                         } else {
                                             return Html::a(Yii::t('app', 'View'),
                                                            ['news/view', 'slug' => $model->slug]);
                                         }

                                     }
                                 ],
                             ],
                         ]); ?>
</div>