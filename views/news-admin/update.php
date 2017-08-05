<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $formParams array */

$this->title                   = Yii::t('app',
                                        'Update {modelClass}: ',
                                        [
                                            'modelClass' => 'News',
                                        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form',
                      [
                          'model'      => $model,
                          'formParams' => $formParams,
                      ]) ?>

</div>
