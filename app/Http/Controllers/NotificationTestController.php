<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;
use App\Services\OneSignalService;

class NotificationTestController extends Controller
{
    public function enviar($userId)
    {
        $device = UserDevice::where('user_id', $userId)->first();

        if (!$device) {
            return "No hay dispositivo registrado para este usuario.";
        }

        OneSignalService::sendNotificationToPlayer(
            $device->player_id,
            'Notificación de prueba',
            'Este es un mensaje de prueba usando OneSignal en Laravel'
        );

        return "Notificación enviada correctamente";
    }
}
