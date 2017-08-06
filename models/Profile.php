<?php

namespace app\models;

use Yii;

/**
 * Class Profile
 * @property integer $notify_type
 */
class Profile extends \dektrium\user\models\Profile
{
    const NOTIFY_TYPE_SITE  = 0;
    const NOTIFY_TYPE_EMAIL = 1;
    const NOTIFY_TYPE_ALL   = 2;

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['create'][]   = 'notify_type';
        $scenarios['update'][]   = 'notify_type';
        $scenarios['register'][] = 'notify_type';

        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();

        $rules['notifyTypeRequired'] = ['notify_type', 'required'];
        $rules['notifyTypeType']     = ['notify_type', 'integer'];

        return $rules;
    }

    /**
     * @return array
     */
    public static function getNotifyTypeArray()
    {
        return [
            self::NOTIFY_TYPE_SITE  => Yii::t('app', 'Site'),
            self::NOTIFY_TYPE_EMAIL => Yii::t('app', 'Email'),
            self::NOTIFY_TYPE_ALL   => Yii::t('app', 'All'),
        ];
    }

    /**
     * @return string
     */
    public function getNotifyTypeName()
    {
        $types = self::getNotifyTypeArray();

        if (isset($types[$this->notify_type])) {
            return $types[$this->notify_type];
        } else {
            return Yii::t('app', '-undefined-');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        $labels['notify_type'] = Yii::t('app', 'Notify type');

        return $labels;
    }
}