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

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'id',
                                 'title',
                                 'image',
                                 [
                                     'class'           => 'kartik\grid\EditableColumn',
                                     'attribute'       => 'status',
                                     'value'           => function ($model, $key, $index) {
                                         return $model->statusName;
                                     },
                                     'editableOptions' => function ($model, $key, $index) {
                                         return [
                                             'formOptions' => [
                                                 'method' => 'post',
                                                 'action' => ['news-admin/ajax-update', 'id' => $model->id]
                                             ],
                                             'attribute'   => 'status',
                                             'value'       => $model->status,
                                             'asPopover'   => false,
                                             'inputType'   => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                             'data'        => \app\models\News::getStatusArray(),
                                             'options'     => ['class' => 'form-control'],
                                         ];
                                     }
                                 ],
                                 'create_time',
                                 'update_time',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>
</div>