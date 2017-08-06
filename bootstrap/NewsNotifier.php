<?php

namespace app\bootstrap;

use app\handlers\NewsHandler;
use app\models\News;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * Class NewsNotifier
 */
class NewsNotifier implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Event::on(News::className(),
                  News::EVENT_NEWS_CREATED,
                  [NewsHandler::className(), 'notifyEverybody']);
    }
}