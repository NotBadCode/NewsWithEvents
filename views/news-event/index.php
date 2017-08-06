<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 [
                                     'format'    => 'html',
                                     'attribute' => 'Event',
                                     'value'     => function ($model) {
                                         if (null === $model->getSenderModel()) {
                                             return Yii::t('app', 'News news:');
                                         } else {
                                             return Yii::t('app', 'News news:') . ' ' .
                                                    Html::a($model->getSenderModel()->title,
                                                            ['news/view', 'slug' => $model->senderModel->slug]);
                                         }
                                     }
                                 ],
                                 'create_time',
                                 [
                                     'format' => 'raw',
                                     'value'  => function ($model) {
                                         return Html::a(Yii::t('app', 'Viewed'),
                                                        ['news-event/change-status', 'id' => $model->id],
                                                        ['data-method' => 'POST']);
                                     }
                                 ],
                             ],
                         ]); ?>
</div>