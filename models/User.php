<?php

namespace app\models;

use yii\db\Expression;

/**
 * Class User
 * @property Profile $profile
 */
class User extends \dektrium\user\models\User
{
    /**
     * @return User[]
     */
    public static function getActiveUsers()
    {
        $users = self::find()
                     ->joinWith('profile', false)
                     ->andWhere(['IS NOT', 'user.confirmed_at', new Expression('NULL')])
                     ->andWhere(['user.blocked_at' => null])
                     ->all();

        return $users;
    }
}