<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        Modal::begin([
                         'toggleButton' => [
                             'label' => '<i class="glyphicon glyphicon-plus"></i> Add',
                             'class' => 'btn btn-success'
                         ],
                         'closeButton'  => [
                             'label' => 'Close',
                             'class' => 'btn btn-danger btn-sm pull-right',
                         ],
                         'size'         => 'modal-lg',
                     ]);
        $myModel = new \app\models\News();
        echo $this->render('_form', ['model' => $myModel, 'formParams' => ['action' => ['news-admin/create']]]);
        Modal::end();
        ?>
    </p>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 'id',
                                 'title',
                                 [
                                     'format' => 'html',
                                     'value'  => function ($model) {
                                         return Html::img($model->getThumbUploadUrl('image', 'news_thumb'));
                                     }
                                 ],
                                 [
                                     'class'           => 'kartik\grid\EditableColumn',
                                     'attribute'       => 'status',
                                     'readonly'        => function ($model) {
                                         return !$model->checkUser();
                                     },
                                     'value'           => function ($model) {
                                         return $model->statusName;
                                     },
                                     'editableOptions' => function ($model) {
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
                                 [
                                     'class'          => 'yii\grid\ActionColumn',
                                     'template'       => '{update} {delete}',
                                     'visibleButtons' => [
                                         'update' => function ($model) {
                                             return $model->checkUser();
                                         },
                                         'delete' => function ($model) {
                                             return $model->checkUser();
                                         }
                                     ]
                                 ],
                             ],
                         ]); ?>
</div>