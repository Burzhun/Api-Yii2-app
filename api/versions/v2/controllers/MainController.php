<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 16:39
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\controllers;


use common\models\localRecord\User;
use yii\web\Controller;
use api\versions\v2\models\requestModels\user\APIFormatter;
use api\versions\v2\models\requestModels\check\Check;
use yii\httpclient\Client;
use yii\httpclient\Response;
use yii\filters\auth\HttpBasicAuth;
use api\versions\v2\models\requestModels\check\Complaint;

class MainController extends Controller
{
	
	/*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'optional' => [
                'index',
				'sendsms',
				'checkcode'
            ],
            'auth' => function($phone, $password) {
                $user = User::findOne(['phone' => $phone]);		
		
                if(empty($user)){
                    return null;
                }
				
                return $user->validateCode($password) ? $user : null;
            }
        ];
        return $behaviors;
    }*/

    public function actionIndex() {

        return User::find()->asArray()->count();
    }

    public function actionSendsms(){
    	if(!isset($_REQUEST['phone'])) return;
		
		header('Content-Type: text/html; charset=utf-8');
    	$cache = \Yii::$app->cache;
    	$phone = $this->fixphone($_REQUEST['phone']);
    	$code  = random_int(100000, 999999);
		$code_cache = $cache->get('phone_smscode_'.$phone);
		if($code_cache){
			header('HTTP/1.0 403 Forbidden');
			echo json_encode(['message'=>'TIME_OUT','errors'=>[['message'=>'Sms-код уже отправлен']]],JSON_UNESCAPED_UNICODE);
			exit;
		}
    	
    	$message = "Код авторизации: {$code}";
		require_once '/var/www/dagdelo.ru/api/versions/v2/controllers/sms.ru.php';
    	$smsru = new SMSRU('E06F2FB6-16E8-F22C-BC1D-D2B19D52E3A9'); // Ваш уникальный программный ключ, который можно получить на главной странице
		$data = new \stdClass();
		$data->to = $phone;
		$data->text = $message; // Текст сообщения
		// $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
		// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
		// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
		// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
		// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
		$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную

		if ($sms->status == "OK") { // Запрос выполнен успешно
			$cache->set('phone_smscode_'.$phone, $code,120);
			echo json_encode(['status'=>true]);
		} else {
			header('HTTP/1.0 403 Forbidden');
			echo json_encode(['status'=>false]);
		}
		exit;
    }

    public function actionCheckcode(){
		
    	if(!isset($_REQUEST['code']) && !isset($_REQUEST['phone'])) return;
		
    	$phone = $this->fixphone($_REQUEST['phone']);    	
    	$code = $_REQUEST['code'];    	
    	$cache = \Yii::$app->cache;
    	$code_cache = $cache->get('phone_smscode_'.$phone);
    	if($cache){
    		if($code == $code_cache){
    			$user = User::findOne(['phone' => str_replace(["-", "(", ")", " ", "+", "_"], "", $phone)]);
		        if(empty($user)){
		            echo json_encode(['success'=>false]);
		        }else{
		        	$api_formatter = new APIFormatter($user);
		        	$token = $api_formatter->getToken()['token'];
					echo json_encode(['auth_key'=>$token,'success'=>true]);
		        }				
    		}else{
				header('HTTP/1.0 403 Forbidden');
				echo json_encode(['message'=>'AUTH_ERROR','errors'=>[['message'=>'Неверный sms-код']]],JSON_UNESCAPED_UNICODE);
			}
			exit;
    	}
		header('HTTP/1.0 403 Forbidden');
		echo json_encode(['message'=>'','errors'=>['message'=>'Ошибка на сайте']],JSON_UNESCAPED_UNICODE);
		exit;
    }
	
	public function actionComplaint(){
		$complaint = new Complaint();		
		$complaint->setAttributes($_REQUEST);
		if($complaint->validate()){
			$collection = \Yii::$app->mongodb->getCollection('complaints');
			$collection->insert($_REQUEST);
			echo json_encode(['success'=>true,'values'=>$_REQUEST]);
			exit;
		}
		echo json_encode(['success'=>false]);
		exit;
		
	}
	
	public function fixphone($phone){
		$phone = str_replace(["-", "(", ")", " ", "+", "_"], "", $phone);
		if(strlen($phone)==11 && $phone[0]=='8') $phone[0] = '7';
		if(strlen($phone)==10) $phone = '7'.$phone;
		return $phone;
	}
	
}