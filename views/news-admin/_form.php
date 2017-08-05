<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\SlugWidget;
use app\models\News;
use app\widgets\ImageInput;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->widget(SlugWidget::className(),
                                             [
                                                 'sourceFieldSelector' => Html::getInputId($model, 'title'),
                                                 'url'                 => ['news-admin/get-model-slug'],
                                                 'options'             => ['class' => 'form-control']
                                             ]); ?>

    <?= $form->field($model, 'image')->widget(ImageInput::className()) ?>

    <?= $form->field($model, 'status')->dropDownList(News::getStatusArray()) ?>

    <?= $form->field($model, 'short_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                               ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
