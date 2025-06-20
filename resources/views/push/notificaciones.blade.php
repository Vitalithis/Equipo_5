<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Notificaciones Push</title>
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
      window.OneSignalDeferred = window.OneSignalDeferred || [];
      OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
          appId: "8eab628f-eb57-43d7-b509-184806b57a9a",
          allowLocalhostAsSecureOrigin: true
        });

        const playerId = await OneSignal.user.getId();
        console.log("Player ID:", playerId);

        // Enviamos el playerId al backend para guardarlo
        await fetch("/device", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ player_id: playerId })
        });
      });
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow text-center">
        <h1 class="text-2xl font-bold mb-4 text-green-600">Notificaciones Push</h1>
        <p class="text-gray-700">Permite las notificaciones para registrar tu dispositivo y recibir mensajes de prueba.</p>
    </div>
</body>
</html>
