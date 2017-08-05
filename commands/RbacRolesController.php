<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Class RbacRolesController
 * @package app\commands
 */
class RbacRolesController extends Controller
{
    public function actionInit()
    {
        $roles = Yii::$app->params['roles'];

        $auth = Yii::$app->authManager;

        $admin = $auth->createRole($roles['admin']);
        $auth->add($admin);

        $manager = $auth->createRole($roles['manager']);
        $auth->add($manager);

        $auth->addChild($admin, $manager);

        $auth->assign($admin, 1);
    }
}