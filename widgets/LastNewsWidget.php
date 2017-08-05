<?php

namespace app\widgets;

use app\models\News;
use yii\base\Model;
use yii\base\Widget;
use app\assets\SlugAsset;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class LastNewsWidget
 */
class LastNewsWidget extends Widget
{

    /**
     * @var integer
     */
    public $limit;

    /**
     * @var string
     */
    public $view = 'last-news';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $news = News::find()
                    ->where(['status' => News::STATUS_ACTIVE])
                    ->limit($this->limit)
                    ->orderBy('create_time')
                    ->all();

        return $this->render($this->view, ['news' => $news]);
    }
}