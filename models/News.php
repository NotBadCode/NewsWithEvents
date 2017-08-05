<?php

namespace app\models;

use mongosoft\file\UploadBehavior;
use mongosoft\file\UploadImageBehavior;
use Yii;
use dektrium\user\models\User;
use yii\behaviors\SluggableBehavior;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $slug
 * @property string  $image
 * @property integer $status
 * @property integer $user_id
 * @property string  $short_text
 * @property string  $text
 * @property string  $create_time
 * @property string  $update_time
 *
 *
 * @property User    $user
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE  = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'status', 'text'], 'required'],
            [['status', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'slug', 'short_text'], 'string', 'max' => 255],
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'title'       => Yii::t('app', 'Title'),
            'slug'        => Yii::t('app', 'Slug'),
            'image'       => Yii::t('app', 'Image'),
            'status'      => Yii::t('app', 'Status'),
            'user_id'     => Yii::t('app', 'User'),
            'short_text'  => Yii::t('app', 'Short Text'),
            'text'        => Yii::t('app', 'Text'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }


    /**
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE  => Yii::t('app', 'Active'),
            self::STATUS_DISABLE => Yii::t('app', 'Disabled'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasMany(User::className(), ['user_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'         => SluggableBehavior::className(),
                'attribute'     => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique'  => true
            ],
            [
                'class'       => UploadImageBehavior::className(),
                'attribute'   => 'image',
                'scenarios'   => ['insert', 'update'],
                'placeholder' => '@app/assets/images/default-news.png',
                'path'        => '@webroot/upload/news/{id}',
                'url'         => '@web/upload/news/{id}',
                'thumbs'      => [
                    'thumb'      => ['width' => 400, 'quality' => 90],
                    'news_thumb' => ['height' => 200, 'bg_color' => '000'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->user_id = Yii::$app->user->getId();

        if (empty($this->short_text)) {
            $this->short_text = StringHelper::truncate($this->text, 250);
        }
        if (empty($this->status)) {
            $this->status = News::STATUS_ACTIVE;
        }

        return parent::beforeValidate();
    }
}
