<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 02.08.2019
 * Time: 15:41
 * Telegram: @JamalWeb
 */

namespace frontend\controllers;


use frontend\components\CheckComponent;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\httpclient\Response;
class ProfileController extends Controller
{
    public $layout = 'profile';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','check-verification'],
                'rules' => [
                    [
                        'actions' => ['index','check-verification'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }



    public function actionIndex()
    {
        /** @var $component CheckComponent */
        $component = \Yii::$app->check;

        $listCheck = $component->getMyOrder(\Yii::$app->user->identity->getId());

        $provider = new ArrayDataProvider([
            'allModels' => $listCheck,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);
        return $this->render('index',[
            'list' => $listCheck,
            'provider' => $provider
        ]);
    }


    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \api\components\HttpException
     */
    public function actionCheckVerification() {
        /** @var $component CheckComponent */
        $component = \Yii::$app->check;
        $model = $component->getModel();
        $component->user_id = \Yii::$app->user->identity->getId();
        if(\Yii::$app->request->isPost){
            $model = $component->getModel(\Yii::$app->request->post());			
            if($component->queryOFD($model)){
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }

        return $this->render('check', [
            'model' => $model
        ]);
    }
	
	public function actionChecks(){
		$component = \Yii::$app->mongodb;

        /** @var $collection Collection */
        $collection = $component->getCollection('check');
		$checks = $collection->find([], [])->toArray();
		$component = \Yii::$app->check;
		$i=0;
		foreach($checks as $check){
				$i++;
				$id = (string)$check['_id'];
				$model = $component->getModel(['CheckForm'=>$check]);
				//if(isset($model->fn)) var_dump($model);
				if(strlen($model->attributes['fn'])==16){
				$client = new Client(['baseUrl' => 'https://api.brand.cash/v2']);
				$request = $client->createRequest()
					->setUrl("/receipts/get")
					->setMethod('GET')
					->setData($model->attributes)
					->setHeaders([
						'X-Api-Key' => '6e91005bdd1fda2ff53f6ad932388b6f',
					]);

				/** @var $response Response */
				$response = $request->send();
				$json = json_decode($response->content);
				var_dump($json);
				$data=$model->attributes;
				/*if($json && isset($json->userInn) && $json->userInn !=''){$i++; $collection->update(['_id'=>new \MongoDB\BSON\ObjectId($id)],['inn'=>$json->userInn]);
				echo $id." ".$json->userInn." </br>";}else{
					$collection->update(['_id'=>new \MongoDB\BSON\ObjectId($id)],['inn'=>'1']);
				}*/
				
				}
				//$collection->update(['_id'=>new \MongoDB\BSON\ObjectId('5d5fdf2f7e1d531e971c1aa1')],['inn'=>'26188019841']);
			
			if($i>6) exit;
		}
		
		exit;
	}

}