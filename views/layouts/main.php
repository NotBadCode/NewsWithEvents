<?php

/* @var $this \yii\web\View */

/* @var $content string */

use kartik\growl\Growl;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$menuItems[] = ['label' => Yii::t('app', 'News'), 'url' => ['/news/index']];
if (Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => Yii::t('app', 'Login'),
        'url'   => ['/user/security/login']
    ];
} else {
    if (Yii::$app->user->can(Yii::$app->params['roles']['manager'])) {
        $menuItems['admin'] = [
            'label' => Yii::t('app', 'Admin'),
            'items' => [
                ['label' => Yii::t('app', 'News'), 'url' => ['/news-admin/index']],
            ]
        ];
    }
    if (Yii::$app->user->identity->getIsAdmin()) {
        $menuItems['admin'] = [
            'label' => Yii::t('app', 'Admin'),
            'items' => [
                ['label' => Yii::t('app', 'News'), 'url' => ['/news-admin/index']],
                ['label' => Yii::t('app', 'Users'), 'url' => ['/user/admin/index']],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['/rbac/role/index']]
            ]
        ];
    }
    $menuItems[] = [
        'label' => Yii::t('app', 'Events'),
        'url'   => ['/news-event/index']
    ];
    $menuItems[] = [
        'label' => Yii::$app->user->identity->username,
        'url'   => ['/user/settings/profile']
    ];
    $menuItems[] = (
        '<li>'
        . Html::beginForm(['/user/security/logout'], 'post')
        . Html::submitButton(
            Yii::t('app', 'Logout'),
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>'
    );
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
                      'brandLabel' => 'My Company',
                      'brandUrl'   => Yii::$app->homeUrl,
                      'options'    => [
                          'class' => 'navbar-inverse navbar-fixed-top',
                      ],
                  ]);
    echo Nav::widget([
                         'options' => ['class' => 'navbar-nav navbar-right'],
                         'items'   => $menuItems,
                     ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <?= Growl::widget([
                          'type'          => Growl::TYPE_SUCCESS,
                          'icon'          => 'glyphicon glyphicon-ok-sign',
                          'title'         => 'Note',
                          'showSeparator' => true,
                          'body'          => $message
                      ]); ?>
<?php endforeach; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
