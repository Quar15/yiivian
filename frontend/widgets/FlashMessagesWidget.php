<?php

namespace frontend\widgets;

use yii\base\Widget;
use Yii;
use yii\helpers\Html;

class FlashMessagesWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $content = '<div class="flash-messages" hx-trigger="newFlashMsg from:body" hx-post="/flash/list" hx-swap="afterbegin" hx-include="#csrf">';
        foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
            $content .= $this->createFlash($key, $message);
        }
        $content .= '</div>';
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
