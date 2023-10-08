<?php

namespace console\controllers;

use common\models\Queue;
use yii\console\Controller;
use yii\db\Expression;
use yii\helpers\Console;

class QueueController extends Controller
{
    public function actionListUnprocessed()
    {
        $unprocessedEntries = Queue::find()
            ->andWhere([Queue::FIELD_IS_PROCESSED => false])
            ->andWhere(['<', Queue::FIELD_EXECUTION_TIMESTAMP, new Expression('NOW()')])
            ->all();
        
        foreach ($unprocessedEntries as $entry) {
            Console::stdout($entry->id . " | " . $entry->command . PHP_EOL);
        }
    }

    public function actionMarkAsProcessed(int $queueEntryId)
    {
        $entry = Queue::findOne($queueEntryId);

        if (! $entry) {
            Console::stdout("@ERROR: Queue($queueEntryId) does NOT exists" . PHP_EOL);
            return 1;
        }

        $entry->is_processed = true;

        if (! $entry->save()) {
            Console::stdout("@ERROR: Failed to mark Queue($queueEntryId) as processed" . PHP_EOL);
            return 1;
        }

        Console::stdout("@SUCCESS: Queue($queueEntryId) marked as processed" . PHP_EOL);
    }
}
