<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "triggered_event_user".
 *
 * @property integer        $id
 * @property integer        $triggered_event_id
 * @property integer        $user_id
 * @property integer        $status
 *
 * @property TriggeredEvent $triggeredEvent
 * @property User           $user
 */
class TriggeredEventUser extends \yii\db\ActiveRecord
{
    const STATUS_VIEWED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'triggered_event_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['triggered_event_id', 'user_id'], 'required'],
            [['triggered_event_id', 'user_id', 'status'], 'integer'],
            [['triggered_event_id', 'user_id'], 'unique', 'targetAttribute' => ['triggered_event_id', 'user_id']],
            [
                ['triggered_event_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => TriggeredEvent::className(),
                'targetAttribute' => ['triggered_event_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'triggered_event_id' => Yii::t('app', 'Triggered Event ID'),
            'user_id'            => Yii::t('app', 'User ID'),
            'status'             => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriggeredEvent()
    {
        return $this->hasOne(TriggeredEvent::className(), ['id' => 'triggered_event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_VIEWED => Yii::t('app', 'Viewed'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        $statuses = self::getStatusArray();

        if (isset($statuses[$this->status])) {
            return $statuses[$this->status];
        } else {
            return Yii::t('app', '-undefined-');
        }
    }
}
