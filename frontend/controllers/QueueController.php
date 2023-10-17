<?php

namespace frontend\controllers;

use common\models\Building;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Queue;
use common\models\Village;
use Exception;
use frontend\widgets\BuildQueueWidget;
use \LogicException;
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
        Yii::$app->response->headers->add('HX-Trigger', 'newFlashMsg');
        if(! isset($_POST['building_id'])) {
            Yii::$app->session->setFlash('error', "Building ID not provided");
            return '';
        }

        $buildingId = $_POST['building_id'];

        $userVillages = Yii::$app->user->identity->villages;
        $relatedVillage = null;
        foreach ($userVillages as $village) {
            $villageBuildingsIds = $village->getAllBuildingsIds();
            if (in_array($buildingId, $villageBuildingsIds)) {
                $relatedVillage = $village;
                break;
            }
        }

        if(! $relatedVillage) {
            Yii::$app->session->setFlash('error', "Building ID is not owned by this account");
            return '';
        }

        $userId = Yii::$app->user->identity->id;
        $villageQueueEntriesCount = Queue::getWaitingUserEntriesOfTypeFromVillage(
            $userId, 
            Queue::QUEUE_TYPE_BUILDING, 
            $relatedVillage->id
        )->count();
        if($villageQueueEntriesCount >= self::QUEUE_LIMIT_PER_USER) {
            Yii::$app->session->setFlash('error', "Queue is already full");
            return $this->renderVillageQueue($relatedVillage->id);
        }

        $nextLevelBuildingType = Building::findOne($buildingId)->getOneNextLevelBuildingType();
        if (! $nextLevelBuildingType) {
            Yii::$app->session->setFlash('error', "That building cannot be upgraded");
            return $this->renderVillageQueue($relatedVillage->id);
        } 

        $duplicate = Queue::find()
            ->andWhere([Queue::FIELD_USER_ID => $userId])
            ->andWhere([Queue::FIELD_VILLAGE_ID => $relatedVillage->id])
            ->andWhere([Queue::FIELD_PRODUCT_ID => $buildingId])
            ->andWhere([Queue::FIELD_QUEUE_TYPE => Queue::QUEUE_TYPE_BUILDING])
            ->andWhere([Queue::FIELD_IS_PROCESSED => false])
            ->limit(1)
            ->one();

        if ($duplicate) {
            Yii::$app->session->setFlash('error', "Already upgrading the building");
            return $this->renderVillageQueue($relatedVillage->id);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $costs = $nextLevelBuildingType->getBuildingCosts()->all();
            $villageResources = $relatedVillage->getVillageResources()->all();
            for ($i=0; $i < count($costs); $i++) {
                if ($costs[$i]->value > $villageResources[$i]->value){
                    Yii::$app->session->setFlash('error', "Not enough resources");
                    throw new LogicException("Not enough resources");
                }

                $villageResources[$i]->value -= $costs[$i]->value;
                if (! $villageResources[$i]->save()) {
                    Yii::$app->session->setFlash('error', "Something went wrong");
                    throw new Exception("Something went wrong");
                }
            }
            $queueModel = Queue::create(
                $userId, 
                $relatedVillage->id,
                $buildingId,
                Queue::QUEUE_TYPE_BUILDING,
                new Expression("NOW() + INTERVAL '" . $nextLevelBuildingType->build_time . " SECONDS'"),
                $nextLevelBuildingType->finish_build_action . ' ' . $buildingId
            );

            if(! $queueModel->save()) {
                Yii::$app->session->setFlash('error', "Something went wrong");
                throw new Exception("Something went wrong");
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        return $this->renderVillageQueue($relatedVillage->id);
    }

    private function renderVillageQueue($villageId): string
    {
        $villageQueue = Queue::getVillageQueueBuildingsList($villageId);
        $queueWidget = BuildQueueWidget::widget([BuildQueueWidget::VILLAGE_QUEUE_BUILDINGS_LIST => $villageQueue]);
        return $queueWidget;
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
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $relatedVillage = Village::findOne($queueEntry->village_id);
            $nextLevelBuildingType = Building::findOne($queueEntry->product_id)->getOneNextLevelBuildingType();  
            $costs = $nextLevelBuildingType->getBuildingCosts()->all();
            $villageResources = $relatedVillage->getVillageResources()->all();

            for ($i=0; $i < count($costs); $i++) {
                $villageResources[$i]->value += ($costs[$i]->value * 0.9);
                if (! $villageResources[$i]->save()) {
                    throw new LogicException("Village Resources could not save");
                }
            }
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', "Something went wrong");
            return $this->redirect(Url::previous());
        }
        
        if(! $queueEntry->delete()) {
            Yii::$app->session->setFlash('error', "Something went wrong");
            return $this->redirect(Url::previous());
        }

        return var_dump(Yii::$app->request->post());
        // @TODO: Return html responses for HTMX
    }
}
