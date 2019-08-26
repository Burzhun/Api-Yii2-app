<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 19:47
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\components;


use api\components\HttpException;
use api\components\RequestCheck;
use api\versions\v2\models\requestModels\check\ApiFormatter;
use api\versions\v2\models\requestModels\check\Check;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Response;
use yii\mongodb\Collection;
use yii\mongodb\Connection;
use yii\mongodb\Exception;

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
            $request = \Yii::$app->getModule('v2')->requestCheck;
            /** @var $result Response */
            $result = $request->queryCheckOFD($check->attributes);
			$json = json_decode($result->content);
            $data = $this->parserCheck($check->attributes,$json->userInn);
			
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

        $check = $this->getCollection()->find(['user_id' => $this->user_id], ['_id' => 0, 's', 'created_at'])->toArray();

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