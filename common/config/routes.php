<?php

use frontend\controllers\SiteController;

return [
    '' => SiteController::ROUTE_INDEX,
    'village' => SiteController::ROUTE_VILLAGE,
    'resources' => SiteController::ROUTE_RESOURCES,
    'signup' => SiteController::ROUTE_REGISTER,
    'login' => SiteController::ROUTE_LOGIN,
    'POST logout' => SiteController::ROUTE_LOGOUT,
];

