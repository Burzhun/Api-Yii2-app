<?php

namespace api\components;

use yii\web\Response;

class HttpException extends \yii\web\HttpException
{
    protected $fields = [];

    public function __construct($status, $message = null, $fields = []) {
        $this->fields = $fields;
        $this->formatError();

        parent::__construct($status, $message);
    }

    private function formatError() {
        \Yii::$app->response->on('beforeSend', function ($event) {
            /** @var $response Response */
            $response = $event->sender;
            if ($response->data !== null && !$response->isSuccessful) {
                $errors = [];
                foreach ($this->fields as $field => $message) {
                    $errors[] = [
                        'field'   => $field,
                        'message' => $message,
                    ];
                }
                $response->data = [
                    'errors'  => $errors,
                    'status'  => $this->statusCode,
                    'message' => $this->message,
                ];
            }
        });
    }
}