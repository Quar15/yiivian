<?php

namespace frontend\controllers;

use common\models\Building;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Queue;
use yii\db\Expression;

/**
 * Queue controller
 */
class QueueController extends Controller
{

    const CONTROLLER_ID = 'queue';

    private const ROUTE_BASE = '/' . self::CONTROLLER_ID . '/';
    
    private const ACTION_UPGRADE_BUILDING = 'upgrade-building';
    private const ACTION_CANCEL_UPGRADE_BUILDING = 'cancel-upgrade-building';

    private const QUEUE_LIMIT_PER_USER = 3;
    
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

    public const ROUTE_UPGRADE_BUILDING = self::ROUTE_BASE . self::ACTION_UPGRADE_BUILDING;
    public function actionUpgradeBuilding()
    {
        if(! isset($_POST['building_id'])) {
            Yii::$app->session->setFlash('error', "Building ID not provided");
            return $this->redirect(Url::previous());
        }

        $buildingId = $_POST['building_id'];

        $userVillages = Yii::$app->user->identity->villages;
        $villageId = -1;
        foreach ($userVillages as $village) {
            $villageBuildingsIds = $village->getAllBuildingsIds();
            if (in_array($buildingId, $villageBuildingsIds)) {
                $villageId = $village->id;
                break;
            }
        }

        if($villageId < 0) {
            Yii::$app->session->setFlash('error', "Building ID is not owned by this account");
            return $this->redirect(Url::previous());
        }

        $userId = Yii::$app->user->identity->id;
        $villageQueueEntriesCount = Queue::getWaitingUserEntriesOfType($userId, Queue::QUEUE_TYPE_BUILDING)
            ->andWhere([Queue::FIELD_VILLAGE_ID => $villageId])
            ->count();
        if($villageQueueEntriesCount >= self::QUEUE_LIMIT_PER_USER) {
            Yii::$app->session->setFlash('error', "Queue is already full");
            return $this->redirect(Url::previous());
        }

        $nextLevelBuildingType = Building::findOne($buildingId)->getOneNextLevelBuildingType();
        
        // @TODO: Check and subtract resources from village

        $duplicate = Queue::find()
            ->andWhere([Queue::FIELD_USER_ID => $userId])
            ->andWhere([Queue::FIELD_VILLAGE_ID => $villageId])
            ->andWhere([Queue::FIELD_PRODUCT_ID => $buildingId])
            ->andWhere([Queue::FIELD_QUEUE_TYPE => Queue::QUEUE_TYPE_BUILDING])
            ->andWhere([Queue::FIELD_IS_PROCESSED => false])
            ->limit(1)
            ->one();

        if ($duplicate) {
            Yii::$app->session->setFlash('error', "Already upgrading the building");
            return $this->redirect(Url::previous());
        }

        $queueModel = Queue::create(
            $userId, 
            $villageId,
            $buildingId,
            Queue::QUEUE_TYPE_BUILDING,
            new Expression("NOW() + INTERVAL '" . $nextLevelBuildingType->build_time . " SECONDS'"),
            $nextLevelBuildingType->finish_build_action . ' ' . $buildingId
        );

        if(! $queueModel->save()) {
            Yii::$app->session->setFlash('error', "Something went wrong");
            return $this->redirect(Url::previous());
        }

        return var_dump(Yii::$app->request->post());
        // @TODO: Return html responses for HTMX
    }

    public const ROUTE_CANCEL_UPGRADE_BUILDING = self::ROUTE_BASE . self::ACTION_CANCEL_UPGRADE_BUILDING;
    public function actionCancelUpgradeBuilding()
    {
        if(! isset($_POST['queue_entry_id'])) {
            Yii::$app->session->setFlash('error', "Queue entry ID not provided");
            return $this->redirect(Url::previous());
        }

        $queueEntryId = $_POST['queue_entry_id'];
        $queueEntry = Queue::findOne($queueEntryId);

        if(! $queueEntry) {
            Yii::$app->session->setFlash('error', "Queue entry does not exists");
            return $this->redirect(Url::previous());
        }

        if(Yii::$app->user->id != $queueEntry->user_id) {
            Yii::$app->session->setFlash('error', "This user is not authorized to do this");
            return $this->redirect(Url::previous());
        }
        
        if(! $queueEntry->delete()) {
            Yii::$app->session->setFlash('error', "Something went wrong");
            return $this->redirect(Url::previous());
        }

        // @TODO: Return resources (90%)

        return var_dump(Yii::$app->request->post());
        // @TODO: Return html responses for HTMX
    }
}
