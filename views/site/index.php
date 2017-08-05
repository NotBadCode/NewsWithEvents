<?php

use app\widgets\LastNewsWidget;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?= LastNewsWidget::widget(); ?>
</div>
