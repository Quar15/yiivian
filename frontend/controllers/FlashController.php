<?php

namespace frontend\controllers;

use frontend\widgets\FlashMessagesWidget;
use Yii;
use yii\web\Controller;

/**
 * Flash message controller
 */
class FlashController extends Controller
{

    const CONTROLLER_ID = 'flash';

    private const ROUTE_BASE = '/' . self::CONTROLLER_ID . '/';
    
    private const ACTION_LIST = 'list';
    
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public const ROUTE_LIST = self::ROUTE_BASE . self::ACTION_LIST;
    public function actionList()
    {
        $content = '';
        foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
            $content .= $this->createFlash($key, $message);
        }
        return $content;
    }

    private function createFlash($key, $message): string
    {
        $flash = '<div class="flash-' . $key . '">';
        $flash .= '<p>' . $message . '</p>';
        $flash .= '</div>';
        return $flash;
    }
}
