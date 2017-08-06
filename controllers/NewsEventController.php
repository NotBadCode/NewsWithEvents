<?php

namespace app\controllers;

use app\models\TriggeredEvent;
use app\models\TriggeredEventUser;
use app\models\User;
use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsEventController implements the CRUD actions for News model.
 */
class NewsEventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'change-status' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = TriggeredEvent::find()
                               ->innerJoin(News::tableName(), 'news.id = sender_id')
                               ->joinWith('triggeredEventUsers teu', true)
                               ->where([
                                           'event'       => News::EVENT_NEWS_CREATED,
                                           'news.status' => News::STATUS_ACTIVE,
                                       ])
                               ->andWhere([
                                              'OR',
                                              ['!=', 'teu.user_id', Yii::$app->user->getId()],
                                              ['teu.user_id' => null]
                                          ]);

        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                               ]);

        return $this->render('index',
                             [
                                 'dataProvider' => $dataProvider,
                             ]);
    }

    /**
     * @param  integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus($id)
    {
        $event = TriggeredEvent::findOne($id);

        if (null === $event) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $eventUser                     = new TriggeredEventUser();
        $eventUser->user_id            = Yii::$app->user->getId();
        $eventUser->triggered_event_id = $event->id;
        $eventUser->save();

        return $this->redirect(['index']);
    }
}