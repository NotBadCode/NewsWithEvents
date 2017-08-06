<?php

namespace app\handlers;

use app\events\NewsEvent;
use app\models\News;
use app\models\Profile;
use app\models\TriggeredEvent;
use app\models\User;
use yii\base\Object;
use Yii;

/**
 * Class NewsHandler
 */
class NewsHandler extends Object
{
    /**
     * @param NewsEvent $event
     */
    public function notifyEverybody(NewsEvent $event)
    {
        $triggeredEvent            = new TriggeredEvent();
        $triggeredEvent->event     = News::EVENT_NEWS_CREATED;
        $news                      = $event->getNews();
        $triggeredEvent->sender    = $news::className();
        $triggeredEvent->sender_id = $news->id;
        $triggeredEvent->save();

        $users = User::getActiveUsers();
        foreach ($users as $user) {
            if (in_array($user->profile->notify_type,
                         [Profile::NOTIFY_TYPE_EMAIL, Profile::NOTIFY_TYPE_ALL])) {
                Yii::$app->mailSender->send($user->email,
                                            Yii::t('app', 'New News on News site!'),
                                            'notify-news',
                                            ['news' => $news]);
            }
        }
    }
}