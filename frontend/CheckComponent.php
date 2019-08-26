<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 03.08.2019
 * Time: 2:23
 * Telegram: @JamalWeb
 */

namespace frontend\components;



use frontend\models\CheckForm;
use yii\base\Component;

class CheckComponent extends Component
{

    /** @var $model CheckForm */
    public $model;

    public function getModel($param = null) {
        /** @var $model CheckForm */
        $model = new $this->model();
        if($param){
            $model->load($param);
        }
        return $model;
    }


}