<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 19:47
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\components;


use api\components\HttpException;
use api\components\RequestCheck;
use api\versions\v1\models\requestModels\check\ApiFormatter;
use api\versions\v1\models\requestModels\check\Check;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Response;
use yii\mongodb\Collection;
use yii\mongodb\Connection;
use yii\mongodb\Exception;
use yii\mongodb\Query;
class CheckVerification extends Component {

    public $user_id;
    public $api_formatter;
    public $check;

    /**
     * @param Check $check
     * @return mixed
     * @throws HttpException
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws Exception
     */
    public function queryScanCheck($check) {

        if ($check->validate()) {
            /** @var $request RequestCheck */
            $request = \Yii::$app->getModule('v1')->requestCheck;
            /** @var $result Response */
            $result = $request->queryCheckOFD($check->attributes);
			$inn='';
			$json = json_decode($result->content);
			if($json && isset($json->userInn) && $json->userInn){ $inn = $json->userInn;}			
            $data = $this->parserCheck($check->attributes,$inn);
			
            return $this->saveCheck($data);

        }else{
            return false;
        }
        throw new HttpException(400, 'Validation Error', $check->getFirstErrors());

    }

    /**
     * @param $data
     * @return bool
     * @throws HttpException
     * @throws Exception
     */
    private function saveCheck($data) {

        try {
            if ($this->getCollection()->save($data)) {
                return true;
            }
        } catch (Exception $exception) {

            throw new HttpException(400, 'Чек существует');
        }

    }


    /**
     * @return array
     * @throws InvalidConfigException
     */
    
	
	 public function getMyChecks() {
		$page_num = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
        //$check = $this->getCollection()->find([], ['_id' => 0, 's', 'created_at','status','inn','t'])->toArray();
		$query = new Query;
		// compose the query
		$query->select(['s', 'created_at','status','inn','t'])
			->from('check')
			->where($this->user_id!=129 ? ['user_id' => $this->user_id]: [])			
			->limit(15)
			->offset(($page_num-1)*15)
			->addOrderBy(['created_at'=> SORT_DESC]);
		// execute the query
		$check = $query->all();
        return $this->getModelApiFormatter($check)->getInfoCheck();
    }

    public function parserCheck($data,$inn=false) {
		if($inn) $data['inn'] = $inn;
        return $data;
    }

    /**
     * @param Response $response
     * @return bool
     * @throws HttpException
     * @throws \yii\httpclient\Exception
     */
    public function errorHandler(Response $response) {

        if ($response->getStatusCode() == 401 || $response->getStatusCode() == 403) {
            throw new HttpException(400, 'Ошибка сервера ОФД');
        } else if ($response->getStatusCode() == 404) {
            throw new HttpException(404, 'Чек не найден в базе ФНС, но может быть найден позже');
        } else if ($response->getStatusCode() == 410) {
            throw new HttpException(404, 'Чек не найден в локальном кеше и не может быть найден в ФНС');
        } else if ($response->getStatusCode() == 406) {
            throw new HttpException(406, 'Чек не легален');
        } else if ($response->getStatusCode() == 429) {
            throw  new HttpException(429, 'Превышен лимит запросов в секунду по одному чеку');
        } else if ($response->getStatusCode() == 500) {
            throw  new HttpException(400, 'Внутренняя ошибка сервера');
        } else if ($response->getStatusCode() == 503) {
            throw new HttpException(400, 'Сервис временно недоступен из-за проблем связанных с ФНС');
        } else if ($response->getStatusCode() == 400) {
            throw new HttpException(400, $response->getData()['error_message']);
        }

        return true;
    }


    public function getCollection() {

        /** @var $component Connection */
        $component = \Yii::$app->mongodb;

        /** @var $collection Collection */
        $collection = $component->getCollection('check');

        return $collection;
    }

    public function getModelCheck($param = null) {

        /** @var $model Check */
        $model = new $this->check();
        if ($param) {
            $model->setAttributes($param);
        }

        return $model;
    }

    public function getModelApiFormatter($check) {

        /** @var $formatter ApiFormatter */
        $formatter = new $this->api_formatter($check);

        return $formatter;
    }


}