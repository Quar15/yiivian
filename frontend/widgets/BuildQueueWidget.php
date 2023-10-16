<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class BuildQueueWidget extends Widget
{
    public const VILLAGE_QUEUE_BUILDINGS_LIST = 'villageQueueBuildingsList';
    public array $villageQueueBuildingsList;

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $elements = '<div id="build-queue" class="build-queue">';
        $elements .= '<h3>Building:</h3>';
        $elements .= '<div class="build-queue-list">';
        foreach ($this->villageQueueBuildingsList as $entry) {
            $elements .= $this->createQueueEntry(
                $entry['id'],
                $entry['building_name'], 
                $entry['building_level'], 
                $entry['endTimestamp']
            );
        }
        $elements .= '</div>';
        $elements .= '</div>';
        return $elements;
    }

    private function createQueueEntry($queueEntryId, $buildingName, $buildingLevel, $timestamp): string
    {
        $timeLeft = $this->convertToHoursMinsSeconds($timestamp - time());
        $endTime = date("H:i:s", $timestamp);
        $queueEntry = '<form class="build-queue-element" action="' . Url::to('queue/cancel-upgrade-building') . '" method="POST">';
        $queueEntry .= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken());
        $queueEntry .= '<input type="hidden" name="queue_entry_id" value="' . $queueEntryId . '"/>';
        $queueEntry .= '<input type="submit" value="X"/>';
        $queueEntry .= '<p>' . $buildingName . ' (Level ' . $buildingLevel . ')</p>';
        $queueEntry .= '<p>' . $timeLeft . '</p>';
        $queueEntry .= '<p>Done at ' . $endTime . '</p>';
        $queueEntry .= '</form>';
        return $queueEntry;
    }

    private function convertToHoursMinsSeconds($seconds, $format = '%02d:%02d:%02d') {
        if ($seconds < 1) {
            return '00:00:00';
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        return sprintf($format, $hours, $minutes, $seconds);
    }
}
