<?php

namespace api\versions\v2\models\requestModels\check;

use yii\base\Model;

class Complaint extends Model{
	public $complaint;
	public $complaint_description;
	public $date;
	public $time;
	public $inn;
	public $place;
	public $place_address;
	public $url;
	public $object;
	public $description;
	public $check_type;
	public $payment_type;
	public $sum;
	
	
	 public function rules()
    {
        return [
            [['complaint','complaint_description','date','time','inn','place','place_address','url','object','description','check_type','payment_type','sum'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'complaint'    => 'Нарушение',
			'complaint_description' =>'Описание',
			'date'    => 'Дата совершения расчета',
			'time'    => 'Время',
			'inn'    => 'Инн',
			'place'    => 'Место совершения расчета',
			'place_address'    => 'Адрес места расчеты',
			'url'    => 'Url интернет магазина',
			'object'    => 'Предмет расчета',
			'description'    => 'Описание предмета расчета',
			'check_type'    => 'Вид кассового чека',
			'payment_type'    => 'Способ оплаты',
			'sum'    => 'Сумма расчета',

        ];
    }
}