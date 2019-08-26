<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 19:00
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\controllers;


use api\versions\v1\controllers\actions\profile\{ActionInfo,ActionEdit};

class ProfileController extends MainController
{
    public function actions()
    {
        return [
            'info'  => ['class' => ActionInfo::class],
            'edit'  => ['class' => ActionEdit::class]
        ];
    }

}