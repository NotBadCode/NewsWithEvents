<?php

namespace app\events;

use app\models\News;
use yii\base\Event;

/**
 * @property News $model
 */
class NewsEvent extends Event
{
    /**
     * @var News
     */
    private $_news;

    /**
     * @return News
     */
    public function getNews()
    {
        return $this->_news;
    }

    /**
     * @param News $news
     */
    public function setNews(News $news)
    {
        $this->_news = $news;
    }
}