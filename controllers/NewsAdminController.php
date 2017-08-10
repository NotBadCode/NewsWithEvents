<?php

namespace app\controllers;

use app\actions\GetModelSlugAction;
use app\models\User;
use kartik\grid\EditableColumnAction;
use kartik\growl\Growl;
use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsAdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $roles = Yii::$app->params['roles'];

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'get-model-slug', 'ajax-update'],
                        'allow'   => true,
                        'roles'   => [$roles['manager']],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'get-model-slug' => [
                'class'     => GetModelSlugAction::className(),
                'modelName' => News::className()
            ],
            'ajax-update'    => [
                'class'           => EditableColumnAction::className(),
                'modelClass'      => News::className(),
                'showModelErrors' => true,
                'postOnly'        => true,
                'ajaxOnly'        => true,
                'outputValue'     => function ($model, $attribute, $key, $index) {
                    return $model->statusName;
                },
            ]
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
                                                   'query' => News::find(),
                                               ]);

        return $this->render('index',
                             [
                                 'dataProvider' => $dataProvider,
                             ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $model->setScenario('insert');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash(Growl::TYPE_SUCCESS, Yii::t('app', 'News successfully added'));


                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash(Growl::TYPE_DANGER, Yii::t('app', 'Error while adding news!'));
            }
        }

        return $this->render('create',
                             [
                                 'model'      => $model,
                                 'formParams' => [],
                             ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash(Growl::TYPE_SUCCESS, Yii::t('app', 'News successfully updated'));


                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash(Growl::TYPE_DANGER, Yii::t('app', 'Error while updating news!'));
            }
        }

        return $this->render('update',
                             [
                                 'model'      => $model,
                                 'formParams' => [],
                             ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (!Yii::$app->user->identity->isAdmin) {
            $model = News::findOne(['id' => $id, 'user_id' => Yii::$app->user->getId()]);
        } else {
            $model = News::findOne($id);
        }

        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            return $model;
        }
    }
}
