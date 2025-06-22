<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones Push</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SDK OneSignal v16 -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>

<script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
        try {
            if (window.__onesignal_initialized) return;
            window.__onesignal_initialized = true;

            await OneSignal.init({
                appId: "8eab628f-eb57-43d7-b509-184806b57a9a", // Usa tu ID real
                allowLocalhostAsSecureOrigin: true,
            });

            // Mostrar prompt (solo si aún no está registrado)
            const permission = await OneSignal.Notifications.permissionNative();
            if (permission !== 'granted') {
                await OneSignal.Notifications.requestPermission();
            }

            // Asociar ID de usuario de Laravel
            @auth
                await OneSignal.user.setExternalUserId("{{ auth()->id() }}");
                console.log("🧩 Usuario autenticado como external_id: {{ auth()->id() }}");
            @endauth

            // Esperar a que OneSignal.user.getId esté disponible
            let retries = 10;
            let playerId = null;

            while ((!OneSignal.user || typeof OneSignal.user.getId !== 'function') && retries-- > 0) {
                console.log("⏳ Esperando OneSignal.user.getId...");
                await new Promise(res => setTimeout(res, 500));
            }

            if (OneSignal.user && typeof OneSignal.user.getId === 'function') {
                playerId = await OneSignal.user.getId();
                console.log("🎯 Player ID:", playerId);
            } else {
                console.error("❌ OneSignal.user no disponible o no tiene método getId().");
            }

            // Guardar en backend si todo bien
            if (playerId) {
                await fetch("/device", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify({ player_id: playerId })
                });
            }

        } catch (e) {
            console.error("🔥 Error al inicializar OneSignal:", e);
        }
    });
</script>



</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow text-center">
        <h1 class="text-xl font-bold mb-4 text-green-700">Notificaciones Push</h1>
        <p class="text-gray-600">Permite las notificaciones para registrar tu dispositivo y recibir mensajes.</p>
    </div>
</body>
</html>
