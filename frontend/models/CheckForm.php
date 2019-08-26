<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 03.08.2019
 * Time: 2:11
 * Telegram: @JamalWeb
 */

namespace frontend\models;

use yii\base\Model;

class CheckForm extends Model
{
    public $fn = '9288000100072710';
    public $i  = '78341' ;
    public $s  = 614.00;
    public $t  = '20190728T161000';
    public $n  = '1';
    public $fp = '4269334371';
	public $inn;

    public function rules()
    {
        return [
			[['inn'],'safe'],
            [['fn','fp','i','s','t','n'],'required'],
            [['fn','fp','i', 'n'], 'integer'],
            ['s',   'number'],
            [['t','inn'],   'string',   'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fn'    => 'ФН',
            'fp'    => 'ФП',
            'i'     => 'I',
            's'     => 'Сумма (например: 614.00)',
            't'     => 'Дата на чеке',
            'n'     => 'Номер (например: 1)',
			'inn'	=> 'Инн'
        ];
    }


}