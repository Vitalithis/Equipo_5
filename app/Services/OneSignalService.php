<?php

namespace App\Services;

use Berkayk\OneSignal\OneSignalFacade as OneSignal;

class OneSignalService
{
    public static function sendNotificationToPlayer($playerId, $title, $message)
    {
        OneSignal::sendNotificationToUser(
            $message,
            $playerId,
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = ["en" => $title]
        );
    }
}
