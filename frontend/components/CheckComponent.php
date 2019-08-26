<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 03.08.2019
 * Time: 2:23
 * Telegram: @JamalWeb
 */

namespace frontend\components;



use api\components\HttpException;
use api\components\RequestCheck;
use frontend\models\CheckForm;
use Yii;
use yii\base\Component;
use yii\httpclient\Response;
use yii\mongodb\Collection;
use yii\mongodb\Connection;
use yii\mongodb\Exception;

class CheckComponent extends Component
{

    /** @var $model CheckForm */
    public $model;
    public $user_id;

    /**
     * @param CheckForm $model
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws HttpException
     */
    public function queryOFD(CheckForm $model) {
        if($model->validate()){
            /** @var $component RequestCheck */
            $component = Yii::$app->requestCheck;

            /** @var $result Response*/
            $result = $component->queryCheckOFD($model->attributes);
            if($this->errorHandler($result)) {
				$json = json_decode($result->content);
				//$model->attributes['inn'] = $json->userInn;
				$inn = isset($json->userInn) ? $json->userInn : '';
                $data = $this->parserCheck($model->attributes,$inn);

                return $this->saveCheck($data);
            }
            return $this->errorHandler($result);

        }


    }

    public function parserCheck($data,$inn=false)
    {
        $data['user_id'] = $this->user_id;
        $data['created_at'] = time();
		if($inn) $data['inn'] = $inn;
        return $data;
    }

    public function getMyOrder($user_id) {

        $listCheck =  $this->getCollection()->find(['user_id' => $user_id])->toArray();

        return $listCheck;

    }


    /**
     * @param $data
     * @return bool
     * @throws HttpException
     */
    public function saveCheck($data) {
        try{
            if($this->getCollection()->save($data)){
                Yii::$app->session->setFlash('success',"Чек сохранен!" );
                return true;
            }
        }catch (Exception $exception){

            Yii::$app->session->setFlash('check_exist','Чек уже существует');
        }
    }

    /**
     * @param $response
     * @return bool
     * @throws HttpException
     * @throws \yii\httpclient\Exception
     */
    public function errorHandler(Response $response) {

        if ($response->getStatusCode() == 401 || $response->getStatusCode() == 403) {
            Yii::$app->session->setFlash('error_request',"{$response->getData()['error_message']}" );
            return false;
        } else if ($response->getStatusCode() == 404) {
            Yii::$app->session->setFlash('error_request',"Чек не найден в базе ФНС, но может быть найден позже" );
            return false;
        }else if ($response->getStatusCode() == 410) {
            Yii::$app->session->setFlash('error_request',"Чек не найден в локальном кеше и не может быть найден в ФНС" );
            return false;
        }
        else if ($response->getStatusCode() == 406){
            Yii::$app->session->setFlash('error_request',"Чек не легален" );
            return false;
        }else if ($response->getStatusCode() == 429) {
            Yii::$app->session->setFlash('error_request',"Превышен лимит запросов в секунду по одному чеку" );
            return false;
        }else if ($response->getStatusCode() == 500 ){
            Yii::$app->session->setFlash('error_request',"Внутренняя ошибка сервера" );
            return false;
        }else if ($response->getStatusCode() == 503) {
            Yii::$app->session->setFlash('error_request',"Сервис временно недоступен из-за проблем связанных с ФНС" );
            return false;
        }else if($response->getStatusCode() == 400) {
            Yii::$app->session->setFlash('error_request',"{$response->getData()['error_message']}" );
            return false;
        }
        return true;
    }

    public function getCollection()
    {
        /** @var $component Connection */
        $component = Yii::$app->mongodb;

        /** @var $collection Collection */
        $collection = $component->getCollection('check');

        return $collection;
    }


    public function getModel($param = null)
    {
        /** @var $model CheckForm */
        $model = new $this->model();
        if($param){
            $model->load($param);
        }
        return $model;
    }


}