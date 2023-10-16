<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "queue".
 *
 * @property int $id
 * @property int $user_id
 * @property int $village_id
 * @property int $product_id
 * @property int $queue_type
 * @property string $execution_timestamp
 * @property string $command
 * @property bool $is_processed
 *
 * @property User $user
 */
class Queue extends ActiveRecord
{
    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_VILLAGE_ID = 'village_id';
    public const FIELD_PRODUCT_ID = 'product_id';
    public const FIELD_QUEUE_TYPE = 'queue_type';
    public const FIELD_EXECUTION_TIMESTAMP = 'execution_timestamp';
    public const FIELD_COMMAND = 'command';
    public const FIELD_IS_PROCESSED = 'is_processed';

    public const QUEUE_TYPE_BUILDING = 1;
    public const QUEUE_TYPE_UNIT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'village_id', 'product_id', 'command'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id', 'queue_type', 'village_id', 'product_id'], 'integer'],
            [['execution_timestamp'], 'safe'],
            [['is_processed'], 'boolean'],
            [['command'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::class, 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'village_id' => 'Village ID',
            'product_id' => 'Product ID',
            'execution_timestamp' => 'Execution Timestamp',
            'command' => 'Command',
            'is_processed' => 'Is Processed',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getVillage()
    {
        return $this->hasOne(User::class, ['id' => 'village_id']);
    }

    public static function getUserEntries(int $userId)
    {
        return Queue::find()
            ->andWhere([self::FIELD_USER_ID => $userId]);
    }

    public static function getWaitingUserEntries(int $userId)
    {
        return Queue::getUserEntries($userId)
            ->andWhere([self::FIELD_IS_PROCESSED => false]);
    }

    public static function getWaitingUserEntriesOfType(int $userId, int $queueType)
    {
        return Queue::getWaitingUserEntries($userId)
            ->andWhere([self::FIELD_QUEUE_TYPE => $queueType]);
    }

    public static function getWaitingUserEntriesOfTypeFromVillage(int $userId, int $queueType, int $villageId)
    {
        return Queue::getWaitingUserEntriesOfType($userId, $queueType)
            ->andWhere([self::FIELD_VILLAGE_ID => $villageId]);
    }

    public static function create(int $userId, int $villageId, int $productId, int $queueType, $executionTimestamp, string $command): Queue
    {
        $queue = new Queue();
        $queue->user_id = $userId;
        $queue->village_id = $villageId;
        $queue->product_id = $productId;
        $queue->queue_type = $queueType;
        $queue->execution_timestamp = $executionTimestamp;
        $queue->command = $command;
        return $queue;
    }

    public static function getVillageQueueBuildingsList(int $villageId)
    {
        $villageQueueEntriesList = Queue::getWaitingUserEntriesOfType(\Yii::$app->user->id, Queue::QUEUE_TYPE_BUILDING)
            ->where([Queue::FIELD_VILLAGE_ID => $villageId])
            ->all();

        $villageQueueBuildingsList = [];
        foreach ($villageQueueEntriesList as $entry) {
            $timestamp = strtotime($entry->execution_timestamp);
            $building = Building::find()
                ->andWhere([Building::FIELD_ID => $entry->product_id])
                ->cache(max($timestamp - time(), 1))
                ->limit(1)
                ->one();

            $villageQueueBuildingsList[] = [
                'id' => $entry->id,
                'building_name' => $building->getBuildingTypeInfo()->one()->name, 
                'building_level' => $building->level + 1, 
                'endTimestamp' => $timestamp,
            ];
        }
        return $villageQueueBuildingsList;
    }
}
