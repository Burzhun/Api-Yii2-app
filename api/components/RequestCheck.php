<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 18:33
 * Telegram: @JamalWeb
 */

namespace api\components;


use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\Response;

class RequestCheck extends Component
{

    /**
     * @param $data
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function queryCheckOFD($data)
    {
        $client = new Client(['baseUrl' => 'https://api.brand.cash/v2']);
            $request = $client->createRequest()
                ->setUrl("/receipts/get")
                ->setMethod('GET')
                ->setData($data)
                ->setHeaders([
                    'X-Api-Key' => '6e91005bdd1fda2ff53f6ad932388b6f',
                ]);

            /** @var $response Response */
            $response = $request->send();
            return $response;
    }

}