<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 30.07.2019
 * Time: 2:20
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\models\requestModels\check;


use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class ApiFormatter extends BaseObject
{

    public $check;

    public function __construct($check, array $config = [])
    {
        $this->check = $check;
        parent::__construct($config);
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getInfoCheck() {
        $formater = \Yii::$app->formatter;
        $arr = [];
        $mongo = \Yii::$app->mongodb;
        $event = $mongo->getCollection('event')->find()->toArray()[0];
        $limit = $event['limit'];
        $date_from = intval(str_replace('-','',$event['dateFrom']));
        $date_to = intval(str_replace('-','',$event['dateTo']));
        $event['days'] = (int)$event['days'];if(!$event['days']) $event['days']=10000;
        foreach ($this->check as $key => $item) {
            $date = $formater->asDate($item['created_at'], 'yyyy-MM-dd');
            $arr[$key]['totalSum']   = $item['s'] . " руб";
			$sum = intval($item['s']);
			$date_int  = (int)$formater->asDate($item['t'], 'yyyyMMdd');
            $days = (int)date('Ymd')-$date_int;
            $status_error='';
            if($item['status']=='Ok'){
                if($sum<$limit){
                    $status_error = "Легален, но сумма чека меньше ".$limit." руб.";
                }elseif($days>$event['days']  || $date_int<$date_from || $date_int>$date_to ){
                    $status_error = "Легален, но дата чека не соответствует условиям акции";
                }else{
                    $status_error = "Зарегистрирован и участвует в акции";
                }
            }else{
                $status_error = 'Не легален';
            }
			if(isset($item['status'])) $arr[$key]['status']   = $item['status']=='Ok' ? ($sum>$limit && ($date_int>$date_from && $date_int<$date_to && $days<$event['days']) ? 1 : 2) : ($item['status']=='Not Acceptable' ? 0 : 0);
			else $arr[$key]['status'] = 3;
            $arr[$key]['status'] = ["status"=>$arr[$key]['status'],"message"=>$status_error];
			$arr[$key]['inn'] = isset($item['inn']) ? $item['inn'] : '';
            $arr[$key]['date_scan']  = $formater->asDate($date, 'php:d M');
            $arr[$key]['date_check'] = $item['t'];
            if(strlen($arr[$key]['date_check'])==13) $arr[$key]['date_check'].='00';
            $arr[$key]['days'] = $days;
        }

        return $arr;
    }

}