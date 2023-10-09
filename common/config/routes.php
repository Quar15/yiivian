<?php

use frontend\controllers\QueueController;
use frontend\controllers\SiteController;

return [
    '' => SiteController::ROUTE_INDEX,
    'village' => SiteController::ROUTE_VILLAGE,
    'resources' => SiteController::ROUTE_RESOURCES,
    'signup' => SiteController::ROUTE_REGISTER,
    'login' => SiteController::ROUTE_LOGIN,
    'POST logout' => SiteController::ROUTE_LOGOUT,
    'POST upgrade-building' => QueueController::ROUTE_UPGRADE_BUILDING,
    'POST queue/upgrade-building' => QueueController::ROUTE_UPGRADE_BUILDING,
    'POST queue/cancel-upgrade-building' => QueueController::ROUTE_CANCEL_UPGRADE_BUILDING,
];

