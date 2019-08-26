<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 30.07.2019
 * Time: 2:20
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\models\requestModels\check;


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
        foreach ($this->check as $key => $item) {
            $date = $formater->asDate($item['created_at'], 'yyyy-MM-dd');
            $arr[$key]['totalSum']   = $item['s'] . " руб";
            $arr[$key]['date_scan']  = $formater->asDate($date, 'php:d M');
        }

        return $arr;
    }

}