<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 02.08.2019
 * Time: 20:43
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\models\requestModels\check;


use yii\base\Model;

class Check extends Model {

    public $user_id;
    public $created_at;
    public $fn;
    public $i;
    public $s;
    public $t;
    public $n;
    public $fp;
	public $type;
	public $inn;


    public function rules() {

        return [
            [['fn', 'fp', 'i', 's', 't', 'n', 'user_id','type','inn','data_check'], 'safe'],
            ['t', 'string', 'max' => 20],
            ['created_at', 'integer'],
			['type', 'integer'],
			['type', 'default', 'value' => 0],
        ];
    }


    public function attributeLabels() {

        return [
            'fn' => 'ФН',
            'i'  => 'ФПД',
			'type' => 'Тип'
        ];
    }


}