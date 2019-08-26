<?php

namespace backend\controllers;

use common\models\localRecord\User;
use Yii;
use yii\mongodb\Connection;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Url;
/**
 * Site controller
 */
class SiteController extends BaseController
{
    public function behaviors()
    {

        return array_merge([
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

        ], parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		if($post=Yii::$app->request->post()){
			$mongo = Yii::$app->mongodb;
			$event = $mongo->getCollection('event')->find()->toArray()[0];
			if(isset($post['name']) && isset($post['value']) && isset($event[$post['name']])){
				$mongo->getCollection('event')->update(['_id'=>new \MongoDB\BSON\ObjectId((string)$event['_id'])],[$post['name']=>$post['value']]);
				
			}
		}
		if(Yii::$app->user->isGuest || Yii::$app->user->identity->email!='admin_tax@email.ru'){
			 \Yii::$app->response->redirect(Url::to('admin/site/login'));
		}
        /** @var $mongo Connection */
        $mongo = Yii::$app->mongodb;
        $cols = User::find()->count();
        $colsCheck = $mongo->getCollection('check')->count();
		$event = $mongo->getCollection('event')->find()->toArray();
        return $this->render('index', [
            'colsUser'  => $cols,
            'colsCheck' => $colsCheck,
			'event'=>$event[0]
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->email=='admin_tax@email.ru') {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }
}
