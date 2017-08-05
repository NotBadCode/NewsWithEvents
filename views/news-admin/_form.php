<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\SlugWidget;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var $formParams null|array */

?>

<div class="news-form">

    <?php $form = ActiveForm::begin($formParams); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->widget(SlugWidget::className(),
                                             [
                                                 'sourceFieldSelector' => '#' . Html::getInputId($model, 'title'),
                                                 'url'                 => ['news-admin/get-model-slug'],
                                                 'options'             => ['class' => 'form-control', 'label' => ''],
                                                 'hidden'              => true,
                                             ]); ?>

    <?php if (!empty($model->image)): ?>
        <?= Html::img($model->getThumbUploadUrl('image'), ['class' => 'img-thumbnail']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'short_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                               ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
