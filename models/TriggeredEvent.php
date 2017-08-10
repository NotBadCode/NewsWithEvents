<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "triggered_event".
 *
 * @property integer              $id
 * @property string               $event
 * @property string               $sender
 * @property integer              $sender_id
 * @property string               $create_time
 *
 * @property TriggeredEventUser[] $triggeredEventUsers
 * @property ActiveRecord         $senderModel
 */
class TriggeredEvent extends \yii\db\ActiveRecord
{
    /**
     * @var ActiveRecord
     */
    public $senderModel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'triggered_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'sender', 'sender_id'], 'required'],
            [['sender_id'], 'integer'],
            [['create_time'], 'safe'],
            [['event', 'sender'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'event'       => Yii::t('app', 'Event'),
            'sender'      => Yii::t('app', 'Sender'),
            'sender_id'   => Yii::t('app', 'Sender ID'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriggeredEventUsers()
    {
        return $this->hasMany(TriggeredEventUser::className(), ['triggered_event_id' => 'id']);
    }

    /**
     * @return ActiveRecord
     */
    public function getSenderModel()
    {
        if (null === $this->senderModel) {
            /**
             * @var ActiveRecord $sender
             */
            $sender            = $this->sender;
            $this->senderModel = $sender::findOne($this->sender_id);
        }

        return $this->senderModel;
    }

    /**
     * @param  integer $userId
     * @return \yii\db\ActiveQuery
     */
    public static function getNewEventsForUserQuery($userId)
    {
        return self::find()
                   ->innerJoin(News::tableName(), 'news.id = sender_id')
                   ->joinWith('triggeredEventUsers teu', true)
                   ->where([
                               'event'       => News::EVENT_NEWS_CREATED,
                               'news.status' => News::STATUS_ACTIVE,
                           ])
                   ->andWhere([
                                  'OR',
                                  ['!=', 'teu.user_id', $userId],
                                  ['teu.user_id' => null]
                              ]);
    }

    /**
     * @param  integer $userId
     * @param  integer $limit
     * @return TriggeredEvent[]
     */
    public static function getLastEventsForUser($userId, $limit = 5)
    {
        return self::getNewEventsForUserQuery($userId)->limit($limit)->all();
    }
}
