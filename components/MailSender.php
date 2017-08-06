<?php

namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Class MailSender
 */
class MailSender extends Component
{
    /**
     * @var string
     */
    public $viewPath = '@app/views/email';

    /**
     * @var string|array
     */
    public $sender;

    public function send($to, $subject, $view, $params = [])
    {
        /**
         * @var \yii\mail\BaseMailer $mailer
         */
        $mailer                   = Yii::$app->mailer;
        $mailer->viewPath         = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if (null === $this->sender) {
            $this->sender = Yii::$app->params['adminEmail'] ?? 'no-reply@example.com';
        }

        return $mailer->compose(['html' => $view], $params)
                      ->setTo($to)
                      ->setFrom($this->sender)
                      ->setSubject($subject)
                      ->send();
    }
}